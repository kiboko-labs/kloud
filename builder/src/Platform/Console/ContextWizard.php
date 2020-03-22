<?php

declare(strict_types=1);

namespace Builder\Platform\Console;

use Builder\Domain\Stack;
use Builder\Platform\Context\CallableContextGuesser;
use Builder\Platform\Context\ContextGuesser;
use Builder\Platform\Context\Guesser;
use Builder\Platform\Context\NoPossibleGuess;
use Composer\Semver\Semver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class ContextWizard
{
    private ?string $cwd;

    public function __construct(?string $cwd = null)
    {
        $this->cwd = $cwd;
    }

    private function buildFromComposer(SymfonyStyle $format): ?Stack\DTO\Context
    {
        $finder = (new Finder())
            ->in($this->cwd)
            ->files()
            ->name('composer.lock');

        if ($finder->hasResults()) {
            /** @var SplFileInfo $file */
            foreach ($finder as $file) {
                $json = \json_decode($file->getContents(), true);
                break;
            }

            $guesser = new ContextGuesser(
                new Guesser\OroCommerceEnterprise('oro/commerce-enterprise'),
                new Guesser\OroCommerceCommunity('oro/commerce'),
                new Guesser\OroCRMEnterprise('oro/crm-enterprise'),
                new Guesser\OroCRMCommunity('oro/crm'),
                new Guesser\MarelloEnterprise('marellocommerce/marello-enterprise'),
                new Guesser\MarelloCommunity('marellocommerce/marello'),
                new Guesser\OroPlatformEnterprise('oro/platform-enterprise'),
                new Guesser\OroPlatformCommunity('oro/platform'),
            );

            $context = $guesser->guess($json['packages'] ?? []);

            if ($context->application === 'orocommerce' && $context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>OroCommerce Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'orocommerce' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>OroCommerce Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'orocrm' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>OroCRM Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'orocrm' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>OroCRM Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'marello' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>Marello Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'marello' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>Marello Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'oroplatform' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>OroPlatform Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            } else if ($context->application === 'oroplatform' && !$context->isEnterpriseEdition) {
                $format->writeln(strtr('Found <fg=yellow>OroPlatform Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
            }

            return $context;
        }

        return null;
    }

    private function buildInteractively(SymfonyStyle $format): ?Stack\DTO\Context
    {
        $context = new Stack\DTO\Context(
            $format->askQuestion(
                (new ChoiceQuestion('Which PHP version are you using?', ['7.1', '7.2', '7.3', '7.4', '8.0'], '7.2'))
            ),
            $format->askQuestion(
                (new ChoiceQuestion('Which application are you using? (leave empty for native image)', ['orocommerce', 'oroplatform', 'orocrm', 'marello', ''], ''))
            ),
            null,
            null
        );

        $context->applicationVersion = '';
        if ('orocommerce' === $context->application) {
            if (Semver::satisfies($context->phpVersion, '>=7.0 <7.2')) {
                $format->writeln(' <fg=green>Choosing automaticallly OroCommerce version 1.6.</>');
                $context->applicationVersion = '1.6';
            } elseif (Semver::satisfies($context->phpVersion, '>=7.1 <7.3')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which OroCommerce version are you using?', ['1.6', '3.1'], '3.1'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.2 <7.4')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which OroCommerce version are you using?', ['3.1', '4.1'], '3.1'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.4')) {
                $format->writeln(' <fg=green>Choosing automaticallly OroCommerce version 4.1.</>');
                $context->applicationVersion = '4.1';
            }
        } elseif ('oroplatform' === $context->application) {
            if (Semver::satisfies($context->phpVersion, '>=7.0 <7.2')) {
                $format->writeln(' <fg=green>Choosing automaticallly OroPlatform version 2.6.</>');
                $context->applicationVersion = '2.6';
            } elseif (Semver::satisfies($context->phpVersion, '>=7.1 <7.3')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which OroPlatform version are you using?', ['2.6', '3.1'], '3.1'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.2 <7.4')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which OroPlatform version are you using?', ['3.1', '4.1'], '3.1'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.4')) {
                $format->writeln(' <fg=green>Choosing automaticallly OroPlatform version 4.1.</>');
                $context->applicationVersion = '4.1';
            }
        } elseif ('orocrm' === $context->application) {
            if (Semver::satisfies($context->phpVersion, '>=7.0 <7.2')) {
                $format->writeln(' <fg=green>Choosing automaticallly OroCRM version 2.6.</>');
                $context->applicationVersion = '2.6';
            } elseif (Semver::satisfies($context->phpVersion, '>=7.1 <7.3')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which OroCRM version are you using?', ['2.6', '3.1'], '3.1'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.2 <7.4')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which OroCRM version are you using?', ['3.1', '4.1'], '3.1'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.4')) {
                $format->writeln(' <fg=green>Choosing automaticallly OroCRM version 4.1.</>');
                $context->applicationVersion = '4.1';
            }
        } elseif ('marello' === $context->application) {
            if (Semver::satisfies($context->phpVersion, '>=7.0 <7.2')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which Marello version are you using?', ['1.5', '1.6'], '1.6'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.1 <7.3')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which Marello version are you using?', ['1.5', '1.6', '2.0', '2.1', '2.2'], '2.2'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.2 <7.4')) {
                $context->applicationVersion = $format->askQuestion(
                    (new ChoiceQuestion('Which Marello version are you using?', ['2.0', '2.1', '2.2', '3.0'], '2.2'))
                );
            } elseif (Semver::satisfies($context->phpVersion, '>=7.4')) {
                $format->writeln(' <fg=green>Choosing automaticallly Marello version 3.0.</>');
                $context->applicationVersion = '3.0';
            }
        }

        $context->isEnterpriseEdition = false;
        if (!empty($context->application)) {
            $context->isEnterpriseEdition = $format->askQuestion(
                (new ConfirmationQuestion('Is it for Enterprise Edition?', false))
            );
        }

        return $context;
    }

    public function __invoke(InputInterface $input, OutputInterface $output): Stack\DTO\Context
    {
        $format = new SymfonyStyle($input, $output);

        $context = null;
        if ($this->cwd !== null) {
            $context = $this->buildFromComposer($format);
        }

        if ($context === null) {
            $context = $this->buildInteractively($format);
        }

        if (!empty($context->application)) {
            $context->dbms = $format->askQuestion(
                (new ChoiceQuestion(
                    'Which database engine are you using?',
                    ['mysql', 'postgresql'],
                    $context->dbms ?? $context->isEnterpriseEdition ? 'postgresql' : 'mysql'
                ))
            );
        } else {
            $context->dbms = $format->askQuestion(
                (new ChoiceQuestion('Which database engine are you using? (leave empty for none)', ['mysql', 'postgresql', ''], ''))
            );
        }

        $context->withBlackfire = $format->askQuestion(
            (new ConfirmationQuestion('Include Blackfire?', $context->withBlackfire ?? false))
        );
        $context->withXdebug = $format->askQuestion(
            (new ConfirmationQuestion('Include XDebug?', $context->withXdebug ?? false))
        );

        $format->table(
            ['php', 'application', 'edition', 'version', 'database', 'blackfire', 'xdebug'],
            [[
                $context->phpVersion,
                $context->application ?: '<native>',
                !empty($context->application) ? ($context->isEnterpriseEdition ? 'enterprise' : 'community') : '',
                $context->applicationVersion,
                $context->dbms ?: '<none>',
                $context->withBlackfire ? 'yes' : 'no',
                $context->withXdebug ? 'yes' : 'no',
            ]]
        );

        return $context;
    }
}
