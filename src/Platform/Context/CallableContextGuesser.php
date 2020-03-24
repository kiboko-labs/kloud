<?php declare(strict_types=1);

namespace Builder\Platform\Context;

use Builder\Domain\Stack;

final class CallableContextGuesser implements ContextGuesserInterface
{
    private string $packageName;
    private \Closure $callback;

    public function __construct(string $packageName, callable $callback)
    {
        $this->packageName = $packageName;
        $this->callback = \Closure::fromCallable($callback);
    }

    public function matches(array $package): bool
    {
        return $package['name'] === $this->packageName;
    }

    public function guess(array $package): Stack\DTO\Context
    {
        return ($this->callback)($package);
    }
}