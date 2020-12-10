<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Placeholder;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\PlaceholderInterface;

final class Any implements PlaceholderInterface
{
    public function matches(FixtureProviderInterface $context, string $value, string $phpVersion, string $applicationVersion)
    {
        return true;
    }

    public function toString(FixtureProviderInterface $context, string $phpVersion, string $applicationVersion): string
    {
        return '<any>';
    }
}
