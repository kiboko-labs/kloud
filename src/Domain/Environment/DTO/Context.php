<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

use Kiboko\Cloud\Domain\Environment\Exception\VariableNotFoundException;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class Context implements NormalizableInterface, DenormalizableInterface
{
    public ?Deployment $deployment;
    public ?Database $database;
    public iterable $environmentVariables;

    public function __construct(?Deployment $deployment = null, ?Database $database = null)
    {
        $this->deployment = $deployment;
        $this->database = $database;
        $this->environmentVariables = [];
    }

    public function addVariable(EnvironmentVariableInterface ...$variable): void
    {
        array_push($this->environmentVariables, ...$variable);
    }

    public function getVariable(string $variableName): EnvironmentVariableInterface
    {
        foreach ($this->environmentVariables as $variable) {
            if ($variableName !== (string) $variable->getVariable()) {
                continue;
            }

            return $variable;
        }

        throw new VariableNotFoundException(strtr('The variable %name% does not exist.', ['%name%' => $variableName]));
    }

    public function setVariable(EnvironmentVariableInterface $newVariable): void
    {
        $i = 0;
        foreach ($this->environmentVariables as $variable) {
            if ((string) $newVariable->getVariable() !== (string) $variable->getVariable()) {
                ++$i;
                continue;
            }
            $this->environmentVariables[$i] = $newVariable;

            return;
        }
    }

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = [])
    {
        $this->deployment = $denormalizer->denormalize($data['deployment'], Deployment::class, $format, $context);
        $this->database = $denormalizer->denormalize($data['database'], Database::class, $format, $context);
        $this->environmentVariables = [];

        $parser = new ExpressionParser();
        foreach ($data['environment'] as $variable) {
            if (isset($variable['value'])) {
                $this->environmentVariables[] = new DirectValueEnvironmentVariable(
                    new Variable($variable['name']),
                    $variable['value']
                );
            } elseif (isset($variable['secret'])) {
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
            'database' => $normalizer->normalize($this->database, $format, $context),
            'environment' => iterator_to_array((function ($variables) {
                /** @var EnvironmentVariableInterface $variable */
                foreach ($variables as $variable) {
                    if ($variable instanceof DirectValueEnvironmentVariable) {
                        yield [
                            'name' => (string) $variable->getVariable(),
                            'value' => $variable->getValue(),
                        ];
                    } elseif ($variable instanceof SecretValueEnvironmentVariable) {
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
            })($this->environmentVariables)),
        ];
    }
}
