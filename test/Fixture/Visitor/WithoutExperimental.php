<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Visitor;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\FixtureVisitorInterface;
use test\Kiboko\Cloud\Fixture\Placeholder;

final class WithoutExperimental implements FixtureVisitorInterface
{
    public function __invoke(FixtureProviderInterface $subject): FixtureProviderInterface
    {
        $subject
            ->withoutExperimental()
        ;
        return $subject;
    }
}
