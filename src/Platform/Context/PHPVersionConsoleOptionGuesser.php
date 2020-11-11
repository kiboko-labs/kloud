<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\PHPVersionConsoleGuesser\PHPVersionConsoleDelegatedGuesserInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class PHPVersionConsoleOptionGuesser implements ContextGuesserInterface, ConsoleOptionContextGuesserInterface
{
    /** @var PHPVersionConsoleDelegatedGuesserInterface[]|iterable */
    private iterable $contextGuessers;

    public function __construct(PHPVersionConsoleDelegatedGuesserInterface ...$contextGuessers)
    {
        $this->contextGuessers = $contextGuessers;
    }

    public function configure(Command $command)
    {
        $command->addOption('php-version', null, InputOption::VALUE_REQUIRED, 'Set up the required PHP version.');
        $command->addOption('application', null, InputOption::VALUE_REQUIRED, 'Set up the required application.');
        $command->addOption('application-version', null, InputOption::VALUE_REQUIRED, 'Set up the required application version.');
        $command->addOption('enterprise', null, InputOption::VALUE_NONE, 'Set up the required application edition to Enterprise Edition.');
        $command->addOption('community', null, InputOption::VALUE_NONE, 'Set up the required application edition to Community Edition.');
    }

    /** @throws NoPossibleGuess */
    public function guess(InputInterface $input, OutputInterface $output, ?Stack\DTO\Context $context = null): Stack\DTO\Context
    {
        $format = new SymfonyStyle($input, $output);

        if (null === ($phpVersion = $input->getOption('php-version'))) {
            $phpVersion = $format->askQuestion(
                (new ChoiceQuestion('Which PHP version are you using?', ['5.6', '7.1', '7.2', '7.3', '7.4', '8.0'], '7.3'))
            );
        }

        if (null === ($application = $input->getOption('application'))) {
            $application = $format->askQuestion(
                (new ChoiceQuestion('Which application are you using? (leave empty for native image)', ['orocommerce', 'oroplatform', 'orocrm', 'marello', 'middleware', ''], ''))
            );
        }

        if ($context === null) {
            $context = new Stack\DTO\Context($phpVersion, $application);
        } else {
            $context->phpVersion = $phpVersion;
            $context->application = $application;
        }

        if (null === ($applicationVersion = $input->getOption('application-version'))) {
            foreach ($this->contextGuessers as $guesser) {
                if (!$guesser->matches($application)) {
                    continue;
                }

                try {
                    $context = $guesser->guess($input, $output, $context);
                    break;
                } catch (NoPossibleGuess $exception) {
                    $format->error($exception->getMessage());
                }
            }
        } else {
            $context->applicationVersion = $applicationVersion;
        }

        $context->isEnterpriseEdition = false;
        if (!empty($context->application)) {
            if ($input->getOption('enterprise') === $input->getOption('community')) {
                $context->isEnterpriseEdition = $format->askQuestion(
                    (new ConfirmationQuestion('Is it for Enterprise Edition?', false))
                );
            } else {
                $context->isEnterpriseEdition = $input->getOption('enterprise');
            }
        }

        if ($context->application === 'orocommerce' && $context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>OroCommerce Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'orocommerce' && !$context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>OroCommerce Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'orocrm' && $context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>OroCRM Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'orocrm' && !$context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>OroCRM Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'marello' && $context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>Marello Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'marello' && !$context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>Marello Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'middleware' && $context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>Middleware Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'middleware' && !$context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>Middleware Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'oroplatform' && $context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>OroPlatform Enterprise Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        } else if ($context->application === 'oroplatform' && !$context->isEnterpriseEdition) {
            $format->writeln(strtr('Choosing <fg=yellow>OroPlatform Community Edition</>, version %version%.', ['%version%' => $context->applicationVersion]));
        }

        return $context;
    }
}
