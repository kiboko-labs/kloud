<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

trait VisitableFixture
{
    public function apply(FixtureVisitorInterface ...$visitors): iterable
    {
        /** @var WizardAssertionFixtureProvider $fixtureProvider */
        foreach ($this->get() as $fixtureProvider) {
            foreach ($visitors as $visitor) {
                $fixtureProvider = $visitor($fixtureProvider);
            }
            yield from $fixtureProvider;
        }
    }
}
