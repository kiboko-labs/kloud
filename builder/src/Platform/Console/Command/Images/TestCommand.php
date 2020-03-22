<?php

declare(strict_types=1);

namespace Builder\Platform\Console\Command\Images;

use Builder\Domain\Assert\AssertionInterface;
use Builder\Domain\Assert\ConstraintInterface;
use Builder\Domain\Assert\Result\AssertionFailureInterface;
use Builder\Domain\Assert\Result\AssertionSuccessInterface;
use Builder\Domain\Assert\ResultBucket;
use Builder\Platform\Console\ContextWizard;
use Builder\Domain\Packaging;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class TestCommand extends Command
{
    public static $defaultName = 'images:test';

    private string $configPath;

    public function __construct(?string $name, string $configPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
    }

    protected function configure()
    {
        $this->setDescription('Test the PHP Docker images');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('working-directory', 'd', InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = (new ContextWizard($workingDirectory))($input, $output)->getImagesRegex();
        }

        $format = new SymfonyStyle($input, $output);

        $format->note(sprintf('Testing all images matching the following pattern: %s', $pattern));

        /** @var Packaging\PackageInterface[] $packages */
        $packages = new \CachingIterator(new \ArrayIterator(array_merge(
            require $this->configPath.'/builds.php',
        )), \CachingIterator::FULL_CACHE);

        $constraints = new \ArrayIterator(require $this->configPath.'/constraints.php');

        $errorCount = 0;
        $bucket = new ResultBucket();
        /** @var Packaging\PackageInterface $package */
        foreach ($packages as $package) {
            $tags = new \IteratorIterator($package);
            if (!empty($pattern)) {
                $tags = new \CallbackFilterIterator($tags, function (Packaging\Tag\TagInterface $tag) use ($pattern) {
                    return preg_match($pattern, (string) $tag) > 0;
                });
            }

            $tags = new \ArrayIterator(iterator_to_array($tags));

            /** @var ConstraintInterface $constraint */
            foreach ($constraints as $constraint) {
                /** @var AssertionInterface $assertion */
                foreach ($constraint->apply($tags) as $assertion) {
                    $result = $assertion();
                    if ($result instanceof AssertionFailureInterface) {
                        ++$errorCount;
                        $bucket->failure($result);
                        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_NORMAL) {
                            $format->error((string) $result);
                        }
                    } else if ($result instanceof AssertionSuccessInterface) {
                        $bucket->success($result);
                        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                            $format->comment((string) $result);
                        }
                    } else {
                        $format->warning((string) $result);
                    }
                }
            }
        }

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
            $rows = [];
            foreach ($packages as $package) {
                $tags = new \IteratorIterator($package);
                if (!empty($pattern)) {
                    $tags = new \CallbackFilterIterator($tags, function (Packaging\Tag\TagInterface $tag) use ($pattern) {
                        return preg_match($pattern, (string) $tag) > 0;
                    });
                }

                $tags = new \ArrayIterator(iterator_to_array($tags));

                foreach ($tags as $tag) {
                    $rows[] = [
                        (string)$tag,
                        implode(PHP_EOL, array_map(function (AssertionSuccessInterface $success) {
                            return (string)$success;
                        }, $bucket->getSuccessesFor($tag))) ?: '❗️ Image may be broken or no checks were provided',
                    ];
                }
            }
            $format->table(['Tag', 'Message'], $rows);
        }

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $rows = [];
            foreach ($packages as $package) {
                $tags = new \IteratorIterator($package);
                if (!empty($pattern)) {
                    $tags = new \CallbackFilterIterator($tags, function (Packaging\Tag\TagInterface $tag) use ($pattern) {
                        return preg_match($pattern, (string)$tag) > 0;
                    });
                }

                $tags = new \ArrayIterator(iterator_to_array($tags));

                foreach ($tags as $tag) {
                    $rows[] = [
                        (string)$tag,
                        implode(PHP_EOL, array_map(function (AssertionFailureInterface $failure) {
                            return (string)$failure;
                        }, $bucket->getFailuresFor($tag))) ?: '✔️ All checks passed',
                    ];
                }
            }
            $format->table(['Tag', 'Message'], $rows);
        }

        if ($errorCount > 0) {
            $format->error(sprintf('❌ Found %d errors, please check logs.', $errorCount));

            return 1;
        }

        $format->success('✔️ All checks passed!');

        return 0;
    }
}
