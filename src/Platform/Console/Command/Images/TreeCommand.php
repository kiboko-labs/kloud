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

final class TreeCommand extends Command
{
    public static $defaultName = 'images:tree';

    private string $configPath;
    private ContextWizard $wizard;

    public function __construct(
        string $configPath,
        ?string $name = null
    ) {
        $this->configPath = $configPath;
        $this->wizard = new ContextWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Show PHP Docker images dependency tree');

        $this->addOption('php-images-regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('dbgp-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/dbgp');
        $this->addOption('postgresql-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/postgresql');
        $this->addOption('php-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/php');

        $this->wizard->configureConsoleCommand($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('php-images-regex'))) {
            $pattern = ($this->wizard)($input, $output)->getPHPImagesRegex();
        }

        $format = new SymfonyStyle($input, $output);

        $packages = Packaging\Config\Config::builds(
            $this->configPath,
            new Packaging\Repository($input->getOption('dbgp-repository')),
            new Packaging\Repository($input->getOption('postgresql-repository')),
            new Packaging\Repository($input->getOption('php-repository')),
            (bool) $input->getOption('with-experimental')
        );
        $builder = new Packaging\DependencyTree\TreeBuilder();

        /** @var Packaging\PackageInterface $package */
        foreach ($packages as $package) {
            $builder->build(...$package);
        }

        $nodes = new \IteratorIterator($builder);
        if (!empty($pattern)) {
            $nodes = new \CallbackFilterIterator($nodes, function (Packaging\DependencyTree\NodeInterface $node) use ($pattern) {
                return preg_match($pattern, (string) $node) > 0;
            });
        }

        $format->writeln('The following tags dependencies does match:');
        foreach ($builder->resolve(...$nodes) as $node) {
            $this->printNode($format, $pattern, $node);
        }

        return 0;
    }

    private function showMatch(?string $pattern, Packaging\DependencyTree\NodeInterface $node): string
    {
        return !empty($pattern) ? preg_replace($pattern, '<comment>\0</>', (string) $node) : (string) $node;
    }

    private function printNode(OutputInterface $output, ?string $pattern, Packaging\DependencyTree\NodeInterface $node, int $level = 0): void
    {
        if (0 === $level) {
            $output->writeln('- '.$this->showMatch($pattern, $node));
        } else {
            $output->writeln(sprintf('  %2$s> %1$s', $this->showMatch($pattern, $node), str_pad('', ($level * 2), ' ', STR_PAD_LEFT)));
        }

        if (count($node)) {
            foreach ($node as $child) {
                $this->printNode($output, $pattern, $child, $level + 1);
            }
        }
    }
}
