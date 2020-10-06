<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment;

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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class StopCommand extends Command
{
    public static $defaultName = 'environment:stop';

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
        $this->setDescription('Stoptty docker services on the remote server');

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

        $command = 'cd '.$context->deployment->path.'/'.$projectName.' && docker-compose stop';

        array_push($tasks, new Task('docker:stop', function () use ($command, $host) {
            run($command);
        }));

        $seriesExecutor = new SeriesExecutor($input, $output, new Informer(new OutputWatcher($output)));
        $seriesExecutor->run($tasks, $hosts);

        return 0;
    }
}
