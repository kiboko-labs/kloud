<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\PHPVersionConsoleGuesser;

use Composer\Semver\Semver;
use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\NoPossibleGuess;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Marello implements PHPVersionConsoleDelegatedGuesserInterface
{
    const CODE = 'marello';

    public function matches(string $application): bool
    {
        return $application === self::CODE;
    }

    public function guess(InputInterface $input, OutputInterface $output, Stack\DTO\Context $context): Stack\DTO\Context
    {
        $format = new SymfonyStyle($input, $output);

        if (Semver::satisfies($context->phpVersion, '>=5.6 <7.2')) {
            $context->applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which Marello version are you using?', ['1.5', '1.6'], '1.6'))
            );
        } else if (Semver::satisfies($context->phpVersion, '>=7.1 <7.3')) {
            $context->applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which Marello version are you using?', ['1.5', '1.6', '2.0', '2.1', '2.2'], '2.2'))
            );
        } else if (Semver::satisfies($context->phpVersion, '>=7.2 <7.4')) {
            $context->applicationVersion = $format->askQuestion(
                (new ChoiceQuestion('Which Marello version are you using?', ['2.0', '2.1', '2.2', '3.0'], '2.2'))
            );
        } elseif (Semver::satisfies($context->phpVersion, '>=7.4')) {
            $format->writeln(' <fg=green>Choosing automaticallly Marello version 3.0.</>');
            $context->applicationVersion = '3.0';
        } else {
            throw NoPossibleGuess::noGuesserMatching();
        }

        return $context;
    }
}