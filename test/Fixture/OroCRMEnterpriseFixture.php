<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class OroCRMEnterpriseFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6'], 'orocrm', ['1.8', '2.6'], true, $this->dbms))
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.1', '7.2', '7.3'], 'orocrm', ['3.1'], true, $this->dbms))
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.3'], 'orocrm', ['3.1'], true, $this->dbms))
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.4'], 'orocrm', ['4.1', '4.2'], true, $this->dbms))
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }
}