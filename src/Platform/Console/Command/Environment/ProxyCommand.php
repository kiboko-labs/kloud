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
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ProxyCommand extends Command
{
    public static $defaultName = 'environment:proxy';
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
        $this->setDescription('Port forwarding using ssh tunnel');

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

        $type = $format->askQuestion(new ChoiceQuestion('What type of port forwarding is it?', ['Local to remote', 'Remote to local']));
        $localPort = $format->askQuestion(new Question('What is the local port you want to tunnel?'));
        $remotePort = $format->askQuestion(new Question('What is the remote port you want to tunnel?'));

        if ('Local' === $type) {
            $process = new Process(['ssh', '-L', $localPort.':'.$host->getHostname().':'.$remotePort, $host->getUser().'@'.$host->getHostname()]);
        } else {
            $process = new Process(['ssh', '-R', $remotePort.':127.0.0.1:'.$localPort, $host->getUser().'@'.$host->getHostname()]);
        }

        try {
            $process->setTty(Process::isTtySupported())->setTimeout(0)->mustRun();
        } catch (\Exception $exception) {
            $format->error($exception->getMessage());

            return 1;
        }

        return 0;
    }
}
