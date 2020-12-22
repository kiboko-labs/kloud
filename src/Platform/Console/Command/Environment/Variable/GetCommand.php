<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment\Variable;

use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Domain\Environment\DTO\SecretValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\ValuedEnvironmentVariableInterface;
use Kiboko\Cloud\Domain\Environment\Exception\VariableNotFoundException;
use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariableInterface;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class GetCommand extends Command
{
    public static $defaultName = 'environment:variable:get';

    private EnvironmentWizard $wizard;

    public function __construct(?string $name)
    {
        $this->wizard = new EnvironmentWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Print an environment variable value');

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

        return 0;
    }
}
