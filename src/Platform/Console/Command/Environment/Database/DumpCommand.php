<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment\Database;

use Deployer\Console\Application;
use Deployer\Deployer;
use Deployer\Host\Host;
use Deployer\Logger\Handler\FileHandler;
use Deployer\Logger\Handler\NullHandler;
use Deployer\Logger\Logger;
use Kiboko\Cloud\Domain\Environment\DTO\Context as EnvironmentContext;
use Kiboko\Cloud\Domain\Stack\DTO\Context as StackContext;
use Kiboko\Cloud\Platform\Console\EnvironmentWizard;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class DumpCommand extends Command
{
    public static $defaultName = 'environment:database:dump';

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
        $this->setDescription('Dumps the database in the current state');

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
            foreach ($finder->name('/^\.?kloud.environment.ya?ml$/') as $environmentFile) {
                try {
                    /** @var EnvironmentContext $environementContext */
                    $environementContext = $serializer->deserialize($environmentFile->getContents(), EnvironmentContext::class, 'yaml');
                } catch (\Throwable $exception) {
                    $format->error($exception->getMessage());
                    continue;
                }

                break;
            }
            foreach ($finder->name('/^\.?kloud.ya?ml$/') as $stackFile) {
                try {
                    /** @var StackContext $stackContext */
                    $stackContext = $serializer->deserialize($stackFile->getContents(), StackContext::class, 'yaml');
                } catch (\Throwable $exception) {
                    $format->error($exception->getMessage());
                    continue;
                }

                break;
            }
        }

        if (!isset($environementContext)) {
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

        $host = new Host($environementContext->deployment->server->hostname);
        $host->port($environementContext->deployment->server->port);
        $host->user($environementContext->deployment->server->username);

        $directories = explode('/', $workingDirectory);
        $projectName = end($directories);
        $remoteProjectPath = $environementContext->deployment->path.'/'.$projectName;

        $sqlService = $format->askQuestion(new Question('What is the name of your SQL service?', 'sql'));
        $process = new Process(['ssh', '-t', $host->getUser().'@'.$host->getHostname(), 'cd', $remoteProjectPath, '&&', 'docker-compose', 'ps', '-q', $sqlService]);

        try {
            $process->mustRun();
            $containerIds = rtrim($process->getOutput(), PHP_EOL);
        } catch (\Exception $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        if (!empty($stackContext->dbms)) {
            $dbms = $stackContext->dbms;
        } else {
            $dbms = strtolower($format->askQuestion(new ChoiceQuestion('Is it a MySQL or PostgreSQL database?', ['MySQL', 'PostgreSQL'])));
        }

        $dumpName = $format->askQuestion(new Question('How do you want to name it?', 'dump.sql'));
        $dumpPath = $remoteProjectPath.'/.docker/'.$dumpName;
        $databaseName = $environementContext->database->databaseName;
        $username = $environementContext->database->username;
        $password = $environementContext->database->password;

        if ('postgresql' === $dbms) {
            $process2 = new Process(['ssh', '-t', $host->getUser().'@'.$host->getHostname(), 'docker', 'exec', '-i', $containerIds, 'pg_dump', '-U', $username, $databaseName, '>', $dumpPath]);
            try {
                $process2->mustRun();
                $format->success('Dump well created at '.$host->getUser().'@'.$host->getHostname().':'.$dumpPath);

                return 0;
            } catch (\Exception $exception) {
                $format->error($exception->getMessage());

                return 1;
            }
        } else {
            $process2 = new Process(['ssh', '-t', $host->getUser().'@'.$host->getHostname(), 'docker', 'exec', $containerIds, '/usr/bin/mysqldump', '-u', $username, '--password='.$password, $databaseName, '>', $dumpPath]);
            try {
                $process2->mustRun();
                if (!file_exists($host->getUser().'@'.$host->getHostname().':'.$dumpPath)) {
                    $format->error('Dump couldn\'t be created');

                    return 1;
                }
                $format->success('Dump well created at '.$host->getUser().'@'.$host->getHostname().':'.$dumpPath);

                return 0;
            } catch (\Exception $exception) {
                $format->error($exception->getMessage());

                return 1;
            }
        }
    }
}
