<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

interface PlaceholderInterface
{
    public function matches(FixtureProviderInterface $context, string $value, string $phpVersion, string $applicationVersion);
}
