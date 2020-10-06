<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment\Variable;

use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Domain\Environment\DTO\DirectValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\EnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\EnvironmentVariableInterface;
use Kiboko\Cloud\Domain\Environment\DTO\SecretValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\ValuedEnvironmentVariableInterface;
use Kiboko\Cloud\Domain\Environment\Exception\VariableNotFoundException;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SetCommand extends Command
{
    public static $defaultName = 'environment:variable:set';

    private EnvironmentWizard $wizard;

    public function __construct(?string $name)
    {
        $this->wizard = new EnvironmentWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Prints an environment variable');

        $this->wizard->configureConsoleCommand($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        $finder = (new Finder())
            ->files()
            ->ignoreDotFiles(false)
            ->in($workingDirectory);

        $format = new SymfonyStyle($input, $output);

        $serializer = new Serializer(
            [
                new CustomNormalizer(),
                new PropertyNormalizer(),
            ],
            [
                new YamlEncoder(),
            ]
        );

        if ($finder->hasResults()) {
            /** @var SplFileInfo $file */
            foreach ($finder->name('/^\.?kloud.environment.ya?ml$/') as $file) {
                try {
                    /** @var Context $context */
                    $context = $serializer->deserialize($file->getContents(), Context::class, 'yaml');
                } catch (\Throwable $exception) {
                    $format->error($exception->getMessage());
                    continue;
                }

                break;
            }
        }

        if (!isset($context)) {
            $format->error('No .kloud.environment.yaml file found in your directory. You must initialize it using environment:init command');

            return 1;
        }

        $variableName = $format->askQuestion(new Question('Please enter a variable name'));

        try {
            /** @var EnvironmentVariableInterface $variable */
            $variable = $context->getVariable($variableName);
        } catch (VariableNotFoundException $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        $format->table(
            ['Variable', 'Value'],
            [
                [
                    $variableName,
                    $variable instanceof ValuedEnvironmentVariableInterface ?
                        $variable->getValue() :
                        ($variable instanceof SecretValueEnvironmentVariable ?
                            sprintf('SECRET: %s', $variable->getSecret()) :
                            null),
                ],
            ]
        );

        // If value is empty, $variable becomes/stay an EnvironmentVariable without any value.
        if (!$value = $this->verifyValue($context, $format, $variable)) {
            $this->sendResponse($context, $format, $serializer, $workingDirectory);

            return 0;
        }

        $isSecret = $format->askQuestion(new ConfirmationQuestion('Is this a secret variable ?', false));

        // Test $variable type and potentially change it according to the answer
        if ($variable instanceof ValuedEnvironmentVariableInterface) {
            if ($isSecret) {
                $context->setVariable(new SecretValueEnvironmentVariable($variable->getVariable(), $value));
            } else {
                $variable->setValue($value);
            }
        }
        if ($variable instanceof SecretValueEnvironmentVariable) {
            if ($isSecret) {
                $variable->setSecret($value);
            } else {
                $context->setVariable(new DirectValueEnvironmentVariable($variable->getVariable(), $value));
            }
        }
        if ($variable instanceof EnvironmentVariable) {
            if ($isSecret) {
                $context->setVariable(new SecretValueEnvironmentVariable($variable->getVariable(), $value));
            } else {
                $context->setVariable(new DirectValueEnvironmentVariable($variable->getVariable(), $value));
            }
        }
        $this->sendResponse($context, $format, $serializer, $workingDirectory);

        return 0;
    }

    private function sendResponse(Context $context, SymfonyStyle $format, Serializer $serializer, string $workingDirectory): void
    {
        $format->success('Variable was successfully changed');
        file_put_contents($workingDirectory.'/.kloud.environment.yaml', $serializer->serialize($context, 'yaml', [
            'yaml_inline' => 4,
            'yaml_indent' => 0,
            'yaml_flags' => 0,
        ]));
    }

    private function verifyValue(Context $context, SymfonyStyle $format, EnvironmentVariableInterface $variable): ?string
    {
        if (!$value = $format->askQuestion(new Question('Please provide the new value'))) {
            $context->setVariable(new EnvironmentVariable($variable->getVariable()));

            return null;
        }

        return $value;
    }
}
