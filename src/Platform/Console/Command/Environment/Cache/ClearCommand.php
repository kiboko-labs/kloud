<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment\Cache;

use Deployer\Console\Application;
use Deployer\Console\Output\Informer;
use Deployer\Console\Output\OutputWatcher;
use Deployer\Deployer;
use Deployer\Executor\SeriesExecutor;
use Deployer\Host\Host;
use function Deployer\run;
use Deployer\Task\Task;
use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ClearCommand extends Command
{
    public static $defaultName = 'environment:cache:clear';

    private Console $console;
    private EnvironmentWizard $wizard;

    public function __construct(?string $name, Console $console)
    {
        $this->console = $console;
        $this->wizard = new EnvironmentWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Clear cache and restart FPM service');

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
                    /** @var \Kiboko\Cloud\Domain\Stack\DTO\Context $context */
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

        $env = $format->askQuestion(new ChoiceQuestion('For what environment ?', ['prod', 'dev', 'test'], 'prod'));

        $application = new Application($this->console->getName());
        $deployer = new Deployer($application);
        $deployer['output'] = $output;

        $hosts = [];
        $tasks = [];

        /** @var Context $context */
        $host = new Host($context->deployment->server->hostname);
        $host->port($context->deployment->server->port);
        $host->user($context->deployment->server->username);
        array_push($hosts, $host);

        $directories = explode('/', $workingDirectory);
        $projectName = end($directories);

        $commands = [
            'cache:clear' => 'cd '.$context->deployment->path.'/'.$projectName.' && docker-compose exec -T sh bin/console cache:clear --env='.$env,
            'docker:restart-fpm' => 'cd '.$context->deployment->path.'/'.$projectName.' && docker-compose restart fpm',
        ];

        foreach ($commands as $key => $value) {
            array_push($tasks, new Task($key, function () use ($value, $host) {
                run($value);
            }));
        }

        $seriesExecutor = new SeriesExecutor($input, $output, new Informer(new OutputWatcher($output)));
        $seriesExecutor->run($tasks, $hosts);

        return 0;
    }
}
