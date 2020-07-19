<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\PHPVersionConsoleGuesser;

use Composer\Semver\Semver;
use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\NoPossibleGuess;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Middleware implements PHPVersionConsoleDelegatedGuesserInterface
{
    const CODE = 'middleware';

    public function matches(string $application): bool
    {
        return $application === self::CODE;
    }

    public function guess(InputInterface $input, OutputInterface $output, Stack\DTO\Context $context): Stack\DTO\Context
    {
        $format = new SymfonyStyle($input, $output);

        if (Semver::satisfies($context->phpVersion, '>=7.4')) {
            $format->writeln(' <fg=green>Choosing automaticallly Middleware version 1.0.</>');
            $context->applicationVersion = '1.0';
        } else {
            throw NoPossibleGuess::noGuesserMatching();
        }

        return $context;
    }
}