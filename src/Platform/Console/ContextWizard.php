<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console;

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
    private ContextGuesserInterface $guesser;

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

        $command->addOption('mysql', null, InputOption::VALUE_NONE, 'Set up the application to use MySQL.');
        $command->addOption('postgresql', null, InputOption::VALUE_NONE, 'Set up the application to use PostgreSQL.');
        $command->addOption('with-xdebug', null, InputOption::VALUE_NONE, 'Set up the application to use Xdebug.');
        $command->addOption('without-xdebug', null, InputOption::VALUE_NONE, 'Set up the application without Xdebug.');
        $command->addOption('with-blackfire', null, InputOption::VALUE_NONE, 'Set up the application to use Blackfire.');
        $command->addOption('without-blackfire', null, InputOption::VALUE_NONE, 'Set up the application without Blackfire.');
        $command->addOption('with-elastic', null, InputOption::VALUE_NONE, 'Set up the application with ElasticStack logging (Kibana).');
        $command->addOption('without-elastic', null, InputOption::VALUE_NONE, 'Set up the application without ElasticStack logging (Kibana).');
    }

    public function __invoke(InputInterface $input, OutputInterface $output): Stack\DTO\Context
    {
        $context = $this->guesser->guess($input, $output, null);

        $format = new SymfonyStyle($input, $output);

        if ($input->getOption('enterprise') === $input->getOption('community')) {
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
        if ($input->getOption('with-elastic')) {
            $context->withElasticStack = true;
        } else if ($input->getOption('without-elastic')) {
            $context->withElasticStack = false;
        } else {
            $context->withXdebug = $format->askQuestion(
                (new ConfirmationQuestion('Include ElasticStack?', $context->withElasticStack ?? false))
            );
        }

        $format->table(
            ['php', 'application', 'edition', 'version', 'database', 'blackfire', 'xdebug', 'elastic-stack'],
            [[
                $context->phpVersion,
                $context->application ?: '<native>',
                !empty($context->application) ? ($context->isEnterpriseEdition ? 'enterprise' : 'community') : '',
                $context->applicationVersion,
                $context->dbms ?: '<none>',
                $context->withBlackfire ? 'yes' : 'no',
                $context->withXdebug ? 'yes' : 'no',
                $context->withElasticStack ? 'yes' : 'no',
            ]]
        );

        return $context;
    }
}
