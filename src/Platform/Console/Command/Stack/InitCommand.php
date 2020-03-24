<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Stack;

use Kiboko\Cloud\Domain\Stack\DTO\Context;
use Kiboko\Cloud\Domain\Stack\OroPlatform;
use Kiboko\Cloud\Domain\Stack\StackBuilder;
use Kiboko\Cloud\Platform\Console\ContextWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InitCommand extends Command
{
    public static $defaultName = 'stack:init';

    private string $configPath;
    private string $stacksPath;

    public function __construct(?string $name, string $configPath, string $stacksPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
        $this->stacksPath = $stacksPath;
    }

    protected function configure()
    {
        $this->setDescription('Initialize the Docker stack in a project without Docker stack');

        $this->addOption('working-directory', 'd', InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        $format = new SymfonyStyle($input, $output);

        if (file_exists($workingDirectory . '/.kloud.yml')) {
            $format->error('The directory was already initialized with a Docker stack.');
            return 0;
        }

        $context = (new ContextWizard($workingDirectory))($input, $output);

        $builder = new StackBuilder(
            new OroPlatform\Builder($this->stacksPath),
        );

        $stack = $builder->build($context);

        $stack->saveTo($workingDirectory);

        return 0;
    }
}