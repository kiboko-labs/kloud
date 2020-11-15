<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

trait VisitableFixture
{
    public function apply(FixtureVisitorInterface ...$visitors): iterable
    {
        /** @var FixtureProviderInterface $fixtureProvider */
        foreach ($this->get() as $fixtureProvider) {
            foreach ($visitors as $visitor) {
                $fixtureProvider = $visitor($fixtureProvider);
            }
            yield from $fixtureProvider;
        }
    }
}
