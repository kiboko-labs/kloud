<?php declare(strict_types=1);

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

    public function __construct(?string $name, string $configPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
    }

    protected function configure()
    {
        $this->setDescription('Show PHP Docker images dependency tree');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('working-directory', 'd', InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = (new ContextWizard($workingDirectory))($input, $output)->getImagesRegex();
        }

        /** @var Packaging\PackageInterface[] $packages */
        $packages = new \CachingIterator(new \ArrayIterator(array_merge(
            require $this->configPath.'/builds.php',
        )), \CachingIterator::FULL_CACHE);
        $format = new SymfonyStyle($input, $output);

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
