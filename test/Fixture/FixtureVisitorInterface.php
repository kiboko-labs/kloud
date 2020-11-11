<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

interface FixtureVisitorInterface
{
    public function __invoke(WizardAssertionFixtureProvider $subject): WizardAssertionFixtureProvider;
}
