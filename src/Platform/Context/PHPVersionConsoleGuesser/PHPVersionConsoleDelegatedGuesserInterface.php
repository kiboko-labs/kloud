<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\PHPVersionConsoleGuesser;

use Kiboko\Cloud\Domain\Stack;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface PHPVersionConsoleDelegatedGuesserInterface
{
    public function matches(string $application): bool;
    public function guess(InputInterface $input, OutputInterface $output, Stack\DTO\Context $context): Stack\DTO\Context;
}