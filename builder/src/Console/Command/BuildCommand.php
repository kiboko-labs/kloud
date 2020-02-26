<?php declare(strict_types=1);

namespace Builder\Console\Command;

use Builder\Command\CommandBus;
use Builder\Command\SequentialCommandRunner;
use Builder\Console\Wizard;
use Builder\DependencyTree\NodeInterface;
use Builder\DependencyTree\TreeBuilder;
use Builder\Package\PackageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class BuildCommand extends Command
{
    private string $configPath;

    public function __construct(string $name, string $configPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
    }

    protected function configure()
    {
        $this->setName('build');
        $this->setDescription('Build PHP Docker images, with an interactive wizard');
        $this->setAliases(['wizard']);

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('force', 'f', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = (new Wizard())($input, $output);
        }

        $format = new SymfonyStyle($input, $output);

        $format->note(sprintf('Building all images matching the following pattern: %s', $pattern));

        /** @var PackageInterface[] $packages */
        $packages = new \CachingIterator(new \ArrayIterator(array_merge(
            require $this->configPath . '/versions.php',
            require $this->configPath . '/packages.php',
        )), \CachingIterator::FULL_CACHE);

        $builder = new TreeBuilder();

        /** @var PackageInterface $package */
        foreach ($packages as $package) {
            $builder->build(...$package);
        }

        $nodes = new \IteratorIterator($builder);
        if (!empty($pattern)) {
            $nodes = new \CallbackFilterIterator($nodes, function (NodeInterface $node) use ($pattern) {
                return preg_match($pattern, (string)$node) > 0;
            });
        }

        $commandBus = new CommandBus();
        /** @var NodeInterface $node */
        foreach ($builder->resolve(...$nodes) as $node) {
            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $format->writeln(strtr('Found <info>%tagName%</>.', ['%tagName%' => (string)$node]));
            }

            $node->build($commandBus);
        }

        (new SequentialCommandRunner($input, $output))->run($commandBus);

        return 0;
    }
}