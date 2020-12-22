<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment;

use Deployer\Console\Application;
use Deployer\Deployer;
use Deployer\Host\Host;
use Deployer\Logger\Handler\FileHandler;
use Deployer\Logger\Handler\NullHandler;
use Deployer\Logger\Logger;
use Deployer\Utility\ProcessOutputPrinter;
use Deployer\Utility\Rsync;
use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class RsyncCommand extends Command
{
    public static $defaultName = 'environment:rsync';

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
        $this->setDescription('Synchronize remote directory according to local directory');

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
        $deployer['log_handler'] = function ($deployer) {
            return !empty($deployer->config['log_file'])
                ? new FileHandler($deployer->config['log_file'])
                : new NullHandler();
        };
        $deployer['logger'] = function ($deployer) {
            return new Logger($deployer['log_handler']);
        };
        $rsync = new Rsync(new ProcessOutputPrinter($output, $deployer['logger']));

        /** @var Context $context */
        $host = new Host($context->deployment->server->hostname);
        $host->port($context->deployment->server->port);
        $host->user($context->deployment->server->username);

        $destination = $host->getUser().'@'.$host->getHostname().':'.$context->deployment->path;
        $config = [
          'options' => [
              '--delete',
          ],
        ];

        try {
            $format->note('Syncing remote directory with local directory');
            $rsync->call($host->getHostname(), $workingDirectory, $destination, $config);
            $format->success('Remote directory synced with local directory');
        } catch (ProcessFailedException $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        return 0;
    }
}
