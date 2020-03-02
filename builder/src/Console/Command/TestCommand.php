<?php declare(strict_types=1);

namespace Builder\Console\Command;

use Builder\Assert\AssertionInterface;
use Builder\Assert\ConstraintInterface;
use Builder\Assert\Result\AssertionFailureInterface;
use Builder\BuildableTagInterface;
use Builder\Console\Wizard;
use Builder\DependencyTree\NodeInterface;
use Builder\DependencyTree\TreeBuilder;
use Builder\DependentTagInterface;
use Builder\Package\PackageInterface;
use Builder\TagInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class TestCommand extends Command
{
    private string $configPath;

    public function __construct(string $name, string $configPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
    }

    protected function configure()
    {
        $this->setName('test');
        $this->setDescription('Test the PHP Docker images');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = (new Wizard())($input, $output);
        }

        $format = new SymfonyStyle($input, $output);

        $format->note(sprintf('Testing all images matching the following pattern: %s', $pattern));

        /** @var PackageInterface[] $packages */
        $packages = new \CachingIterator(new \ArrayIterator(array_merge(
            require $this->configPath . '/versions.php',
            require $this->configPath . '/packages.php',
        )), \CachingIterator::FULL_CACHE);

        $constraints = new \ArrayIterator(require $this->configPath . '/constraints.php');

        $errorCount = 0;
        /** @var PackageInterface $package */
        foreach ($packages as $package) {
            $tags = new \IteratorIterator($package);
            if (!empty($pattern)) {
                $tags = new \CallbackFilterIterator($tags, function (TagInterface $tag) use ($pattern) {
                    return preg_match($pattern, (string)$tag) > 0;
                });
            }

            $tags = new \ArrayIterator(iterator_to_array($tags));

            /** @var ConstraintInterface $constraint */
            foreach ($constraints as $constraint) {
                /** @var AssertionInterface $assertion */
                foreach ($constraint->apply($tags) as $assertion) {
                    $result = $assertion();
                    if ($result instanceof AssertionFailureInterface) {
                        $errorCount++;
                        $format->error((string) $result);
                    } else if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                        $format->comment((string) $result);
                    }
                }
            }
        }

        if ($errorCount > 0) {
            $format->error(sprintf('Found %d errors, please check logs.', $errorCount));
            return 1;
        }
        $format->success('All checks passed!');

        return 0;
    }
}