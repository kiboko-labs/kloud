<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class Context implements NormalizableInterface, DenormalizableInterface
{
    public ?Deployment $deployment;
    public iterable $environmentVariables;

    public function __construct(?Deployment $deployment = null)
    {
        $this->deployment = $deployment;
        $this->environmentVariables = [];
    }

    public function addVariables(EnvironmentVariableInterface ...$variables): void
    {
        array_push($this->environmentVariables, ...$variables);
    }

    public function getVariableValue(string $variableName)
    {
        foreach ($this->environmentVariables as $variable) {
            if ($variable instanceof DirectValueEnvironmentVariable) {
                if ($variableName === $variable->getVariable()->__toString()) {
                    $value = $variable->getValue()->__toString();
                    if (!$value) {
                        $value = ' ';
                    }
                    return $value;
                }
            } else if ($variable instanceof SecretValueEnvironmentVariable) {
                if ($variableName === $variable->getVariable()->__toString()) {
                    return '**secret**';
                }
            } else {
                if ($variableName === $variable->getVariable()->__toString()) {
                    return ' ';
                }
            }
        }
    }

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = [])
    {
        $this->deployment = $denormalizer->denormalize($data['deployment'], Deployment::class, $format, $context);
        $this->environmentVariables = [];

        $parser = new ExpressionParser();
        foreach ($data['environmentVariables'] as $variable) {
            if (isset($variable['value'])) {
                $this->environmentVariables[] = new DirectValueEnvironmentVariable(
                    new Variable($variable['name']),
                    $parser->parse($variable['value'])
                );
            } else if (isset($variable['secret'])) {
                $this->environmentVariables[] = new SecretValueEnvironmentVariable(
                    new Variable($variable['name']),
                    $variable['secret']
                );
            } else {
                $this->environmentVariables[] = new EnvironmentVariable(
                    new Variable($variable['name'])
                );
            }
        }
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        return [
            'deployment' => $normalizer->normalize($this->deployment, $format, $context),
            'environment' => (function($variables) {
                /** @var EnvironmentVariableInterface $variable */
                foreach ($variables as $variable) {
                    if ($variable instanceof DirectValueEnvironmentVariable) {
                        yield [
                            'name' => (string) $variable->getVariable(),
                            'value' => $variable->getValue(),
                        ];
                    } else if ($variable instanceof SecretValueEnvironmentVariable){
                        yield [
                            'name' => (string) $variable->getVariable(),
                            'secret' => $variable->getSecret(),
                        ];
                    } else {
                        yield [
                            'name' => (string) $variable->getVariable(),
                        ];
                    }
                }
            })($this->environmentVariables),
        ];
    }
}
