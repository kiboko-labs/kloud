<?php declare(strict_types=1);

namespace Builder\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Wizard
{
    public function __invoke(InputInterface $input, OutputInterface $output): string
    {
        $format = new SymfonyStyle($input, $output);

        $phpVersion = $format->askQuestion(
            (new ChoiceQuestion('Which PHP version are you using?', ['7.1', '7.2', '7.3', '7.4', '8.0'], '7.2'))
        );

        $application = $format->askQuestion(
            (new ChoiceQuestion('Which application are you using? (leave empty for native image)', ['orocommerce', 'oroplatform', 'orocrm', 'marello', ''], ''))
        );

        $applicationVersion = '';
        if ($application === 'orocommerce') {
            $applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which OroCommerce version are you using?', ['1.6', '3.1', '4.1'], '3.1'))
            );
        } else if ($application === 'oroplatform') {
            $applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which OroPlatform version are you using?', ['2.6', '3.1', '4.1'], '3.1'))
            );
        } else if ($application === 'orocrm') {
            $applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which OroCRM version are you using?', ['2.6', '3.1', '4.1'], '3.1'))
            );
        } else if ($application === 'marello') {
            $applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which Marello version are you using?', ['1.6', '2.0', '2.1', '2.2', '3.0'], '2.2'))
            );
        }

        $enterpriseEdition = false;
        if (!empty($application)) {
            $enterpriseEdition = $format->askQuestion(
                (new ConfirmationQuestion('Is it for Enterprise Edition?', false))
            );
            $dbms = $format->askQuestion(
                (new ChoiceQuestion('Which database engine are you using?', ['mysql', 'postgresql'], $enterpriseEdition ? 'postgresql' : 'mysql'))
            );
        } else {
            $dbms = $format->askQuestion(
                (new ChoiceQuestion('Which database engine are you using? (leave empty for none)', ['mysql', 'postgresql', ''], ''))
            );
        }

        $withBlackfire = $format->askQuestion(
            (new ConfirmationQuestion('Include Blackfire?', false))
        );
        $withXdebug = $format->askQuestion(
            (new ConfirmationQuestion('Include XDebug?', false))
        );

        $format->table(
            ['php', 'application', 'edition', 'version', 'database', 'blackfire', 'xdebug'],
            [[
                $phpVersion,
                $application ?: '<native>',
                !empty($application) ? ($enterpriseEdition ? 'enterprise' : 'community') : '',
                $applicationVersion,
                $dbms ?: '<none>',
                $withBlackfire ? 'yes' : 'no',
                $withXdebug ? 'yes' : 'no',
            ]]
        );

        if ($withBlackfire && $withXdebug) {
            $variations = '(?:|-blackfire|-xdebug)';
        } else if ($withBlackfire && !$withXdebug) {
            $variations = '(?:|-blackfire)';
        } else if (!$withBlackfire && $withXdebug) {
            $variations = '(?:|-xdebug)';
        } else {
            $variations = '';
        }

        if (empty($application)) {
            if (empty($dbms)) {
                return sprintf('/^%s-(?:cli|fpm)%s$/', preg_quote($phpVersion), $variations);
            } else {
                return sprintf('/^%s-(?:cli|fpm)%s-%s$/', preg_quote($phpVersion), $variations, $dbms);
            }
        } else {
            return sprintf('/^%s-(?:cli|fpm)%s-%s-%s-%s-%s$/', preg_quote($phpVersion), $variations, $application, $enterpriseEdition ? 'ee' : 'ce', preg_quote($applicationVersion), $dbms);
        }
    }
}