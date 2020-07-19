<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Kiboko\Cloud\Domain\Stack;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ContextGuesserFacade implements ContextGuesserInterface, ConsoleOptionContextGuesserInterface
{
    /** @var ContextGuesserInterface[]|iterable  */
    private iterable $contextGuessers;

    public function __construct(ContextGuesserInterface ...$contextGuessers)
    {
        $this->contextGuessers = $contextGuessers;
    }

    public function guess(InputInterface $input, OutputInterface $output, ?Stack\DTO\Context $context = null): Stack\DTO\Context
    {
        foreach ($this->contextGuessers as $guesser) {
            try {
                return $guesser->guess($input, $output, $context);
            } catch (NoPossibleGuess $exception) {
                continue;
            }
        }

        throw NoPossibleGuess::noGuesserMatching();
    }

    public function configure(Command $command)
    {
        foreach ($this->contextGuessers as $contextGuesser) {
            if ($contextGuesser instanceof ConsoleOptionContextGuesserInterface) {
                $contextGuesser->configure($command);
            }
        }
    }
}