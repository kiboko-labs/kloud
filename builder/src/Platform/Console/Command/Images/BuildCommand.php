<?php

declare(strict_types=1);

namespace Builder\Platform\Console\Command\Images;

use Builder\Domain\Packaging;
use Builder\Platform\Console\ContextWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class BuildCommand extends Command
{
    public static $defaultName = 'images:build';

    private string $configPath;

    public function __construct(?string $name, string $configPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
    }

    protected function configure()
    {
        $this->setDescription('Build PHP Docker images, with an interactive wizard');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Force the build for matching images only.');
        $this->addOption('force-all', 'a', InputOption::VALUE_NONE, 'Force the build for all matching images and dependencies.');
        $this->addOption('parallel', 'P', InputOption::VALUE_OPTIONAL, '[EXPERIMENTAL] Run the build commands in parallel', 'no');
        $this->addOption('push', 'p', InputOption::VALUE_NONE, 'Push images to Docker Hub (requires authentication).');

        $this->addOption('working-directory', 'd', InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = (new ContextWizard($workingDirectory))($input, $output)->getImagesRegex();
        }

        $format = new SymfonyStyle($input, $output);

        $format->note(sprintf('Building all images matching the following pattern: %s', $pattern));

        /** @var Packaging\PackageInterface[] $packages */
        $packages = new \CachingIterator(new \ArrayIterator(array_merge(
            require $this->configPath.'/builds.php',
        )), \CachingIterator::FULL_CACHE);

        $format->table(['tag', 'parent', 'path'], iterator_to_array((function () use ($pattern, $packages) {
            /** @var Packaging\PackageInterface $package */
            foreach ($packages as $package) {
                $tags = new \IteratorIterator($package);
                if (!empty($pattern)) {
                    $tags = new \CallbackFilterIterator($tags, function (Packaging\Tag\TagInterface $tag) use ($pattern) {
                        return preg_match($pattern, (string) $tag) > 0;
                    });
                }

                foreach ($tags as $tag) {
                    yield [
                        'tag' => !empty($pattern) ? preg_replace($pattern, '<comment>\0</>', (string) $tag) : (string) $tag,
                        'parent' => $tag instanceof Packaging\Tag\DependentTagInterface ? $tag->getParent() : null,
                        'path' => ($context = $tag->getContext()) instanceof Packaging\Context\BuildableContextInterface ? $context->getPath() : null,
                    ];
                }
            }
        })()));

        $tree = new Packaging\DependencyTree\TreeBuilder();

        /** @var Packaging\PackageInterface $package */
        foreach ($packages as $package) {
            $tree->build(...$package);
        }

        $nodes = new \IteratorIterator($tree);
        if (!empty($pattern)) {
            $nodes = new \CallbackFilterIterator($nodes, function (Packaging\DependencyTree\NodeInterface $node) use ($pattern) {
                return preg_match($pattern, (string) $node) > 0;
            });
        }

        $force = ((bool) $input->getOption('force')) ?? false;
        $forceAll = ((bool) $input->getOption('force-all')) ?? false;

        $commandBus = new Packaging\CommandBus\CommandBus();
        /** @var Packaging\DependencyTree\NodeInterface $node */
        foreach ($tree->resolve(...$nodes) as $node) {
            if ($force && preg_match($pattern, (string) $node) > 0 || $forceAll) {
                if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
                    $format->writeln(strtr('Found <options=bold;fg=green>%tagName%</>, at path <fg=yellow>%path%</> (<fg=blue>force build</>).', ['%tagName%' => (string) $node, '%path%' => $node->getPath()]));
                } elseif ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                    $format->writeln(strtr('Found <options=bold;fg=green>%tagName%</> (<fg=blue>force build</>).', ['%tagName%' => (string) $node]));
                }

                $node->forceBuild($commandBus);
            } else {
                if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
                    $format->writeln(strtr('Found <options=bold;fg=green>%tagName%</>, at path <fg=yellow>%path%</>.', ['%tagName%' => (string) $node, '%path%' => $node->getPath()]));
                } elseif ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                    $format->writeln(strtr('Found <options=bold;fg=green>%tagName%</>.', ['%tagName%' => (string) $node]));
                }

                $node->build($commandBus);
            }

            if ($input->getOption('push')) {
                $node->push($commandBus);
            }
        }

        if ('no' === $input->getOption('parallel') || 1 === (int) $input->getOption('parallel')) {
            (new Packaging\CommandBus\SequentialCommandRunner($input, $output))->run($commandBus);
        } else {
            $parallel = (int) $input->getOption('parallel');
            (new Packaging\CommandBus\ParallelCommandRunner($input, $output, $parallel > 0 ? $parallel : 12))->run($commandBus);
        }

        return 0;
    }
}
