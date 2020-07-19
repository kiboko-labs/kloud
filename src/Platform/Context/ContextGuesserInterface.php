<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Kiboko\Cloud\Domain\Stack;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ContextGuesserInterface
{
    /** @throws NoPossibleGuess */
    public function guess(InputInterface $input, OutputInterface $output, ?Stack\DTO\Context $context = null): Stack\DTO\Context;
}