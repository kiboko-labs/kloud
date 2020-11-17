<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\PHPVersionConsoleGuesser;

use Composer\Semver\Semver;
use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\NoPossibleGuess;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class OroCommerce implements PHPVersionConsoleDelegatedGuesserInterface
{
    const CODE = 'orocommerce';

    public function matches(string $application): bool
    {
        return $application === self::CODE;
    }

    public function guess(InputInterface $input, OutputInterface $output, Stack\DTO\Context $context): Stack\DTO\Context
    {
        $format = new SymfonyStyle($input, $output);

        if (Semver::satisfies($context->phpVersion, '>=5.6 <7.1')) {
            $format->writeln(' <fg=green>Choosing automaticallly OroCommerce version 1.6.</>');
            $context->applicationVersion = '1.6';
        } else if (Semver::satisfies($context->phpVersion, '>=7.1 <7.3')) {
            $context->applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which OroCommerce version are you using?', ['1.6', '3.1'], '3.1'))
            );
        } else if (Semver::satisfies($context->phpVersion, '>=7.2 <7.4')) {
            $context->applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which OroCommerce version are you using?', ['3.1', '4.1'], '4.1'))
            );
        } else if (Semver::satisfies($context->phpVersion, '>=7.4')) {
            $context->applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which OroCommerce version are you using?', ['4.1', '4.2'], '4.2'))
            );
        } else if (Semver::satisfies($context->phpVersion, '>=8.0')) {
            $format->writeln(' <fg=green>Choosing automaticallly OroCommerce version 4.2.</>');
            $context->applicationVersion = '4.2';
        } else {
            throw NoPossibleGuess::noGuesserMatching();
        }

        return $context;
    }
}
