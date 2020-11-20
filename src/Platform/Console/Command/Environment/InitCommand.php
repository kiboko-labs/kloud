<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment;

use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Domain\Environment\DTO\Database;
use Kiboko\Cloud\Domain\Environment\DTO\Deployment;
use Kiboko\Cloud\Domain\Environment\DTO\DirectValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\SecretValueEnvironmentVariable;
use Kiboko\Cloud\Domain\Environment\DTO\Server;
use Kiboko\Cloud\Domain\Environment\DTO\Variable;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class InitCommand extends Command
{
    public static $defaultName = 'environment:init';

    private EnvironmentWizard $wizard;

    public function __construct(?string $name)
    {
        $this->wizard = new EnvironmentWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Initialize the environment file in local workspace');

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
            /** @var \SplFileInfo $file */
            foreach ($finder->name('/^\.?kloud.environment.ya?ml$/') as $file) {
                $format->error('The directory was already initialized with an environment file. You should update it using commands listed in environment:variable');

                return 0;
            }
        }

        $format = new SymfonyStyle($input, $output);

        $context = new Context(
            new Deployment(
                new Server(
                    $format->askQuestion(new Question('Please provide the SSH host of your remote environment')),
                    $format->askQuestion(new Question('Please provide the SSH port of your remote environment', 22)),
                    $format->askQuestion(new Question('Please provide the SSH user name of your remote environment', 'root')),
                ),
                $format->askQuestion(new Question('Please provide the path to your remote environment')),
            ),
            new Database(
                $format->askQuestion(new Question('Please provide the name of your database')),
                $format->askQuestion(new Question('Please provide the user\'s name of your database')),
                $format->askQuestion(new Question('Please provide the user\'s password of your database')),
            ),
        );

        $envDistPath = getcwd().'/.env.dist';
        if (file_exists($envDistPath)) {
            $envDist = parse_ini_file($envDistPath);
            foreach (array_keys($envDist) as $name) {
                $value = $format->askQuestion(new Question('Value of '.$name));

                $isSecret = false;
                if ($value) {
                    $isSecret = $format->askQuestion(new ConfirmationQuestion('Is this a secret variable ?', false));
                }

                if ($isSecret) {
                    $context->addVariable(new SecretValueEnvironmentVariable(new Variable($name), $value));
                } else {
                    $context->addVariable(new DirectValueEnvironmentVariable(new Variable($name), $value));
                }
            }
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
