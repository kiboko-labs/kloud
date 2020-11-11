<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Visitor;

use test\Kiboko\Cloud\Fixture\FixtureVisitorInterface;
use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class WithoutBlackfire implements FixtureVisitorInterface
{
    public function __invoke(WizardAssertionFixtureProvider $subject): WizardAssertionFixtureProvider
    {
        return $subject->withoutBlackfire();
    }
}
