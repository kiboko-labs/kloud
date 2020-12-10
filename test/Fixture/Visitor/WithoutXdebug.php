<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Visitor;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\FixtureVisitorInterface;

final class WithoutXdebug implements FixtureVisitorInterface
{
    public function __invoke(FixtureProviderInterface $subject): FixtureProviderInterface
    {
        return $subject->withoutXdebug();
    }
}
