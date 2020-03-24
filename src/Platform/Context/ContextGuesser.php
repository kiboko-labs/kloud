<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Kiboko\Cloud\Domain\Stack;

final class ContextGuesser
{
    /** @var ContextGuesserInterface[]|iterable */
    private iterable $contextGuessers;

    public function __construct(ContextGuesserInterface ...$contextGuessers)
    {
        $this->contextGuessers = $contextGuessers;
    }

    private function filterPackages(array $packages): array
    {
        return array_filter($packages, function (array $package) {
            return array_reduce($this->contextGuessers, function (bool $carry, ContextGuesserInterface $guesser) use ($package) {
                return $carry || $guesser->matches($package);
            }, false);
        });
    }

    public function guess(array $packages): Stack\DTO\Context
    {
        $packages = $this->filterPackages($packages);

        foreach ($this->contextGuessers as $guesser) {
            try {
                foreach ($packages as $package) {
                    if (!$guesser->matches($package)) {
                        continue;
                    }

                    return $guesser->guess($package);
                }
            } catch (NoPossibleGuess $exception) {
                continue;
            }
        }

        throw NoPossibleGuess::packageIsNotMatchingAnyApplicationContext();
    }
}