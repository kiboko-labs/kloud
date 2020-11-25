<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Kiboko\Cloud\Domain\Packaging\Repository;
use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\ComposerPackageGuesser\ComposerPackageDelegatedGuesserInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class ComposerPackageGuesser implements ContextGuesserInterface, ConsoleOptionContextGuesserInterface
{
    /** @var ComposerPackageDelegatedGuesserInterface[]|iterable */
    private iterable $contextGuessers;

    public function __construct(ComposerPackageDelegatedGuesserInterface ...$contextGuessers)
    {
        $this->contextGuessers = $contextGuessers;
    }

    public function configure(Command $command)
    {
        $command->addOption('working-directory', 'd', InputOption::VALUE_OPTIONAL, 'Change the working directory in which the stack will be guessed from and written.');

        if (!$command->getDefinition()->hasOption('dbgp-repository')) {
            $command->addOption('dbgp-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/dbgp');
        }
        if (!$command->getDefinition()->hasOption('postgresql-repository')) {
            $command->addOption('postgresql-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/postgresql');
        }
        if (!$command->getDefinition()->hasOption('php-repository')) {
            $command->addOption('php-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/php');
        }
    }

    private function filterPackages(array $packages): array
    {
        return array_filter($packages, function (array $package) {
            return array_reduce($this->contextGuessers, function (bool $carry, ComposerPackageDelegatedGuesserInterface $guesser) use ($package) {
                return $carry || $guesser->matches($package);
            }, false);
        });
    }

    /** @throws NoPossibleGuess */
    public function guess(InputInterface $input, OutputInterface $output, ?Stack\DTO\Context $context = null): Stack\DTO\Context
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        $finder = (new Finder())
            ->in($workingDirectory)
            ->files()
            ->name('composer.lock');

        if (!$finder->hasResults()) {
            throw NoPossibleGuess::packageIsNotMatchingAnyApplicationContext();
        }

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $json = \json_decode($file->getContents(), true);
            break;
        }

        if (!isset($json)) {
            throw NoPossibleGuess::packageIsNotMatchingAnyApplicationContext();
        }

        $packages = $this->filterPackages($json['packages']);

        $repository = new Repository($input->getOption('php-repository'));

        $format = new SymfonyStyle($input, $output);
        foreach ($this->contextGuessers as $guesser) {
            try {
                foreach ($packages as $package) {
                    if (!$guesser->matches($package)) {
                        continue;
                    }

                    $context = $guesser->guess($repository, $package);

                    if ($context->application === 'orocommerce' && $context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>OroCommerce Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'orocommerce' && !$context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>OroCommerce Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'orocrm' && $context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>OroCRM Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'orocrm' && !$context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>OroCRM Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'marello' && $context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>Marello Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'marello' && !$context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>Marello Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'oroplatform' && $context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>OroPlatform Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'oroplatform' && !$context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>OroPlatform Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'middleware' && $context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>Middleware Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else if ($context->application === 'middleware' && !$context->isEnterpriseEdition) {
                        $format->writeln(strtr('Found <fg=yellow>Middleware Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
                    } else {
                        $format->writeln(strtr('Found <fg=yellow>%application%</>, version %version%.', ['%application%' => $context->application, '%version%' => $context->applicationVersion]));
                    }

                    return $context;
                }
            } catch (NoPossibleGuess $exception) {
                $format->warning('Could not guess any known application type.');
                continue;
            }
        }

        throw NoPossibleGuess::packageIsNotMatchingAnyApplicationContext();
    }
}
