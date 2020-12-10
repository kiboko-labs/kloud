<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

interface FixtureVisitorInterface
{
    public function __invoke(FixtureProviderInterface $subject): FixtureProviderInterface;
}
