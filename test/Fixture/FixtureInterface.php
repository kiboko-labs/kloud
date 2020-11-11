<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

interface FixtureInterface
{
    public function get(): iterable;
    public function apply(FixtureVisitorInterface ...$visitors): iterable;
}
