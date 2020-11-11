<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class MiddlewareCommunityFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['7.4'], 'middleware', ['1.0'], false, $this->dbms))
            ->expectMessages(
                'Choosing Middleware Community Edition, version %applicationVersion%.',
            )
        ;
    }
}
