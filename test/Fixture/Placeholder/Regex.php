<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Placeholder;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\PlaceholderInterface;

final class Regex implements PlaceholderInterface
{
    private string $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function matches(FixtureProviderInterface $context, string $value, string $phpVersion, string $applicationVersion)
    {
        return 0 < preg_match($this->pattern, $value);
    }

    public function toString(FixtureProviderInterface $context, string $phpVersion, string $applicationVersion): string
    {
        return sprintf('<regex %s>', $this->pattern);
    }
}
