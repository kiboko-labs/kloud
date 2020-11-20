<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment;

use Deployer\Host\Host;
use Kiboko\Cloud\Domain\Environment\DTO\Context;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ShellCommand extends Command
{
    public static $defaultName = 'environment:shell';
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
        $this->setDescription('Start a shell session for a service');

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

        $host = new Host($context->deployment->server->hostname);
        $host->port($context->deployment->server->port);
        $host->user($context->deployment->server->username);

        $directories = explode('/', $workingDirectory);
        $projectName = end($directories);
        $remoteProjectPath = $context->deployment->path.'/'.$projectName;

        $service = $format->askQuestion(new Question('For what service you want to start a shell session?'));
        $process = new Process(['ssh', '-t', $host->getUser().'@'.$host->getHostname(), 'cd', $remoteProjectPath, '&&', 'docker-compose', 'ps', '-q', $service]);
        try {
            $process->mustRun();
            $containerIds = rtrim($process->getOutput(), PHP_EOL);
        } catch (\Exception $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        $process2 = new Process(['ssh', '-t', $host->getUser().'@'.$host->getHostname(), 'cd', $remoteProjectPath, '&&', 'docker', 'exec', '-ti', $containerIds, 'sh']);
        try {
            $process2->setTty(Process::isTtySupported())->setTimeout(0)->mustRun();
        } catch (\Exception $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        return 0;
    }
}
