<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Images;

use Kiboko\Cloud\Domain\Packaging;
use Kiboko\Cloud\Platform\Console\ContextWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class PushCommand extends Command
{
    public static $defaultName = 'images:push';

    private string $configPath;
    private string $environmentsPath;
    private ContextWizard $wizard;

    public function __construct(?string $name, string $configPath, string $environmentsPath)
    {
        $this->configPath = $configPath;
        $this->environmentsPath = $environmentsPath;
        $this->wizard = new ContextWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Push PHP Docker images, with an interactive wizard');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('parallel', 'P', InputOption::VALUE_OPTIONAL, '[DEPRECATED] Run the Docker commands in parallel', 'no');

        $this->addOption('with-experimental', 'E', InputOption::VALUE_NONE, 'Enable Experimental images and PHP versions.');

        $this->wizard->configureConsoleCommand($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = ($this->wizard)($input, $output)->getImagesRegex();
        }

        $format = new SymfonyStyle($input, $output);

        $format->note(sprintf('Pushing all images matching the following pattern: %s', $pattern));

        $packages = Packaging\Config\Config::builds($this->configPath, (bool) $input->getOption('with-experimental'));

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

        $commandBus = new Packaging\Execution\CommandBus\CommandBus();
        /** @var Packaging\DependencyTree\NodeInterface $node */
        foreach ($tree->resolve(...$nodes) as $node) {
            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $format->writeln(strtr('Found <info>%tagName%</>.', ['%tagName%' => (string) $node]));
            }

            $node->push($commandBus->task());
        }

//        if ('no' === $input->getOption('parallel') || 1 === (int) $input->getOption('parallel')) {
            (new Packaging\Execution\CommandBus\SequentialCommandRunner($input, $output))->run($commandBus, $this->environmentsPath);
//        } else {
//            $parallel = (int) $input->getOption('parallel');
//            (new Packaging\Execution\CommandBus\ParallelCommandRunner($input, $output, $parallel > 0 ? $parallel : 12))->run($commandBus, $this->environmentsPath);
//        }

        return 0;
    }
}
