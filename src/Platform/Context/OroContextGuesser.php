<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Kiboko\Cloud\Domain\Stack;

final class OroContextGuesser implements ContextGuesserInterface
{
    private string $packageName;

    public function __construct(string $packageName)
    {
        $this->packageName = $packageName;
    }

    public function matches(): callable
    {
        return function(array $package): bool {
            return $package['name'] === $this->packageName;
        };
    }

    public function guess(array $packages): Stack\DTO\Context
    {
        foreach ($packages as $package) {
            try {
                $context = ($this->callback)($package);
            } catch (NoPossibleGuess $exception) {
                continue;
            }

            return $context;
        }

        throw NoPossibleGuess::noVersionMatching();
    }
}