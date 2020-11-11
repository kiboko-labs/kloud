<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class MiddlewareEnterpriseFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['7.4'], 'middleware', ['1.0'], true, $this->dbms))
            ->expectMessages(
                'Choosing Middleware Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }
}
