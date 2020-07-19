<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Images;

use Kiboko\Cloud\Domain\Assert\AssertionInterface;
use Kiboko\Cloud\Domain\Assert\ConstraintInterface;
use Kiboko\Cloud\Domain\Assert\Result\AssertionFailureInterface;
use Kiboko\Cloud\Domain\Assert\Result\AssertionSuccessInterface;
use Kiboko\Cloud\Domain\Assert\Result\AssertionUnprocessableInterface;
use Kiboko\Cloud\Domain\Assert\ResultBucket;
use Kiboko\Cloud\Domain\Packaging;
use Kiboko\Cloud\Platform\Console\ContextWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class TestCommand extends Command
{
    public static $defaultName = 'images:test';

    private string $configPath;
    private ContextWizard $wizard;

    public function __construct(?string $name, string $configPath)
    {
        $this->configPath = $configPath;
        $this->wizard = new ContextWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Test the PHP Docker images');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('with-experimental', 'E', InputOption::VALUE_NONE, 'Enable Experimental images and PHP versions.');

        $this->wizard->configureConsoleCommand($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = ($this->wizard)($input, $output)->getImagesRegex();
        }

        $format = new SymfonyStyle($input, $output);

        $format->note(sprintf('Testing all images matching the following pattern: %s', $pattern));

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

        $constraints = new \ArrayIterator(require $this->configPath.'/constraints.php');

        $errorCount = 0;
        $warningCount = 0;
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
                    if ($result instanceof AssertionUnprocessableInterface) {
                        ++$warningCount;
                        $bucket->failure($result);
                        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_NORMAL) {
                            $format->warning(sprintf("Tag %s:%s\n%s", $assertion->repository, $assertion->tag, (string)$result));
                        }
                    } else if ($result instanceof AssertionFailureInterface) {
                        ++$errorCount;
                        $bucket->failure($result);
                        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_NORMAL) {
                            $format->error(sprintf("Tag %s:%s\n%s", $assertion->repository, $assertion->tag, (string)$result));
                        }
                    } else if ($result instanceof AssertionSuccessInterface) {
                        $bucket->success($result);
                        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                            $format->success(sprintf("Tag %s:%s\n%s", $assertion->repository, $assertion->tag, (string)$result));
                        }
                    } else {
                        $format->note(sprintf("Tag %s:%s\n%s", $assertion->repository, $assertion->tag, (string)$result));
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
                            return sprintf($failure instanceof AssertionUnprocessableInterface ? '❗ %s' : '❌ %s', (string)$failure);
                        }, $bucket->getFailuresFor($tag))) ?: '✔️ All checks passed',
                    ];
                }
            }
            $format->table(['Tag', 'Message'], $rows);
        }

        if ($errorCount <= 0 && $warningCount > 0) {
            $format->warning(sprintf('❗ Found %d warnings, please check your logs.', $warningCount));

            return 0;
        } else if ($errorCount > 0 && $warningCount <= 0) {
            $format->error(sprintf('❌ Found %d errors, please check your logs.', $errorCount));

            return 1;
        } else if ($errorCount > 0 && $warningCount > 0) {
            $format->error(sprintf('❌ Found %d errors and %d warnings, please check your logs.', $errorCount, $warningCount));

            return 1;
        }

        $format->success('✔️ All checks passed!');

        return 0;
    }
}
