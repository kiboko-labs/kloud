<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment\Variable;

use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Domain\Environment\DTO\DirectValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\SecretValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\Variable;
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

final class AddCommand extends Command
{
    public static $defaultName = 'environment:variable:add';

    private EnvironmentWizard $wizard;

    public function __construct(?string $name)
    {
        $this->wizard = new EnvironmentWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Add an environment variable');

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
        $variableValue = $format->askQuestion(new Question('Please enter '.$variableName.' value'));

        $isSecret = false;
        if ($variableValue) {
            $isSecret = $format->askQuestion(new ConfirmationQuestion('Is this a secret variable ?', false));
        }

        if ($isSecret) {
            $context->addVariable(new SecretValueEnvironmentVariable(new Variable($variableName), $variableValue));
        } else {
            $context->addVariable(new DirectValueEnvironmentVariable(new Variable($variableName), $variableValue));
        }

        $format->note('Writing a new .kloud.environment.yaml file.');
        file_put_contents($workingDirectory.'/.kloud.environment.yaml', $serializer->serialize($context, 'yaml', [
            'yaml_inline' => 4,
            'yaml_indent' => 0,
            'yaml_flags' => 0,
        ]));

        return 0;
    }
}
