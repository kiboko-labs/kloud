<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console;

use Composer\Semver\Semver;
use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\ComposerPackageGuesser;
use Kiboko\Cloud\Platform\Context\ContextGuesserFacade;
use Kiboko\Cloud\Platform\Context\ContextGuesserInterface;
use Kiboko\Cloud\Platform\Context\PHPVersionConsoleGuesser;
use Kiboko\Cloud\Platform\Context\PHPVersionConsoleOptionGuesser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ContextWizard
{
    private ?ContextGuesserInterface $guesser = null;

    public function __construct()
    {
        $this->guesser = new ContextGuesserFacade(
            new ComposerPackageGuesser(
                new ComposerPackageGuesser\OroCommerceEnterprise('oro/commerce-enterprise'),
                new ComposerPackageGuesser\OroCommerceCommunity('oro/commerce'),
                new ComposerPackageGuesser\OroCRMEnterprise('oro/crm-enterprise'),
                new ComposerPackageGuesser\OroCRMCommunity('oro/crm'),
                new ComposerPackageGuesser\MarelloEnterprise('marellocommerce/marello-enterprise'),
                new ComposerPackageGuesser\MarelloCommunity('marellocommerce/marello'),
                new ComposerPackageGuesser\MiddlewareCommunity('kiboko/middleware'),
                new ComposerPackageGuesser\OroPlatformEnterprise('oro/platform-enterprise'),
                new ComposerPackageGuesser\OroPlatformCommunity('oro/platform'),
            ),
            new PHPVersionConsoleOptionGuesser(
                new PHPVersionConsoleGuesser\OroPlatform(),
                new PHPVersionConsoleGuesser\OroCRM(),
                new PHPVersionConsoleGuesser\OroCommerce(),
                new PHPVersionConsoleGuesser\Marello(),
                new PHPVersionConsoleGuesser\Middleware(),
            ),
        );
    }

    public function configureConsoleCommand(Command $command)
    {
        $this->guesser->configure($command);

        $command->addOption('php-images-regex', 'x', InputOption::VALUE_REQUIRED);
        $command->addOption('php-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/php');
        $command->addOption('mysql', null, InputOption::VALUE_NONE, 'Set up the application to use MySQL.');
        $command->addOption('postgresql', null, InputOption::VALUE_NONE, 'Set up the application to use PostgreSQL.');
        $command->addOption('with-xdebug', null, InputOption::VALUE_NONE, 'Set up the application to use Xdebug.');
        $command->addOption('without-xdebug', null, InputOption::VALUE_NONE, 'Set up the application without Xdebug.');
        $command->addOption('with-blackfire', null, InputOption::VALUE_NONE, 'Set up the application to use Blackfire.');
        $command->addOption('without-blackfire', null, InputOption::VALUE_NONE, 'Set up the application without Blackfire.');
        $command->addOption('with-dejavu', null, InputOption::VALUE_NONE, 'Set up the application to use Dejavu UI.');
        $command->addOption('without-dejavu', null, InputOption::VALUE_NONE, 'Set up the application without Dejavu UI.');
        $command->addOption('with-elastic-stack', null, InputOption::VALUE_NONE, 'Set up the application to use Elastic Stack logging.');
        $command->addOption('without-elastic-stack', null, InputOption::VALUE_NONE, 'Set up the application without Elastic Stack logging.');
        $command->addOption('with-macos-optimizations', null, InputOption::VALUE_NONE, 'Set up the application to use Docker for Mac optimizations.');
        $command->addOption('without-macos-optimizations', null, InputOption::VALUE_NONE, 'Set up the application without Docker for Mac optimizations.');

        $command->addOption('with-experimental', 'E', InputOption::VALUE_NONE, 'Enable Experimental images and PHP versions.');
    }

    public function __invoke(InputInterface $input, OutputInterface $output): Stack\DTO\Context
    {
        $context = $this->guesser->guess($input, $output, null);

        $format = new SymfonyStyle($input, $output);

        if ($input->getOption('postgresql') === $input->getOption('mysql')) {
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
        } else if ($input->getOption('postgresql') === true) {
            $context->dbms = 'postgresql';
        } else if ($input->getOption('mysql') === true) {
            $context->dbms = 'mysql';
        }

        if ($input->getOption('with-blackfire')) {
            $context->withBlackfire = true;
        } else if ($input->getOption('without-blackfire')) {
            $context->withBlackfire = false;
        } else {
            $context->withBlackfire = $format->askQuestion(
                (new ConfirmationQuestion('Include Blackfire?', $context->withBlackfire ?? false))
            );
        }
        if ($input->getOption('with-xdebug')) {
            $context->withXdebug = true;
        } else if ($input->getOption('without-xdebug')) {
            $context->withXdebug = false;
        } else {
            $context->withXdebug = $format->askQuestion(
                (new ConfirmationQuestion('Include XDebug?', $context->withXdebug ?? false))
            );
        }
        if ($input->getOption('with-dejavu')) {
            $context->withDejavu = true;
        } else if ($input->getOption('without-dejavu')) {
            $context->withDejavu = false;
        } else {
            $context->withDejavu = $format->askQuestion(
                (new ConfirmationQuestion('Include Dejavu UI?', $context->withDejavu ?? false))
            );
        }
        if ($context->isEnterpriseEdition && in_array($context->application, ['oroplatform', 'orocrm']) && Semver::satisfies($context->applicationVersion, '<1.8')
            || !$context->isEnterpriseEdition && in_array($context->application, ['oroplatform', 'orocrm']) && Semver::satisfies($context->applicationVersion, '<1.6')
            || $context->isEnterpriseEdition && in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '<1.2')
            || !$context->isEnterpriseEdition && in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '<1.4')
        ) {
            $format->note('ElasticStack logging is not available with this application version.');
            $context->withElasticStack = false;
        } else if ($input->getOption('with-elastic-stack')) {
            $context->withElasticStack = true;
        } else if ($input->getOption('without-elastic-stack')) {
            $context->withElasticStack = false;
        } else {
            $context->withElasticStack = $format->askQuestion(
                (new ConfirmationQuestion('Include Elastic Stack logging?', $context->withElasticStack ?? false))
            );
        }
        if ($input->getOption('with-macos-optimizations')) {
            $context->withDockerForMacOptimizations = true;
        } else if ($input->getOption('without-macos-optimizations')) {
            $context->withDockerForMacOptimizations = false;
        } else {
            $context->withDockerForMacOptimizations = $format->askQuestion(
                (new ConfirmationQuestion('Activate Docker for Mac optimizations?', $context->withDockerForMacOptimizations ?? false))
            );
        }

        $format->table(
            ['php', 'application', 'edition', 'version', 'database', 'blackfire', 'xdebug', 'dejavu', 'elastic', 'macos'],
            [[
                $context->phpVersion,
                $context->application ?: '<native>',
                !empty($context->application) ? ($context->isEnterpriseEdition ? 'enterprise' : 'community') : '',
                $context->applicationVersion,
                $context->dbms ?: '<none>',
                $context->withBlackfire ? 'yes' : 'no',
                $context->withXdebug ? 'yes' : 'no',
                $context->withDejavu ? 'yes' : 'no',
                $context->withElasticStack ? 'yes' : 'no',
                $context->withDockerForMacOptimizations ? 'yes' : 'no',
            ]]
        );

        return $context;
    }
}
