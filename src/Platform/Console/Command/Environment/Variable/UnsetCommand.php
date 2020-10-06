<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment\Variable;

use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Domain\Environment\DTO\EnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\EnvironmentVariableInterface;
use Kiboko\Cloud\Domain\Environment\Exception\VariableNotFoundException;
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

final class UnsetCommand extends Command
{
    public static $defaultName = 'environment:variable:unset';

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

        $variableName = $format->askQuestion(new Question('Please enter the variable to unset'));

        try {
            /** @var EnvironmentVariableInterface $variable */
            $variable = $context->getVariable($variableName);
        } catch (VariableNotFoundException $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        $context->setVariable(new EnvironmentVariable($variable->getVariable()));

        $format->success('Variable was successfully unset');
        file_put_contents($workingDirectory.'/.kloud.environment.yaml', $serializer->serialize($context, 'yaml', [
            'yaml_inline' => 4,
            'yaml_indent' => 0,
            'yaml_flags' => 0,
        ]));

        return 0;
    }
}
