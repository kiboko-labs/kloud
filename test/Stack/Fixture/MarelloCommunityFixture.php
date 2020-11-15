<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Stack\Fixture;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
use test\Kiboko\Cloud\Stack\WizardAssertionFixtureProvider;

final class MarelloCommunityFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6'], 'marello', ['1.5', '1.6'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.1', '7.2'], 'marello', ['1.5', '1.6', '2.0', '2.1', '2.2'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.3'], 'marello', ['2.0', '2.1', '2.2', '3.0'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.4'], 'marello', ['3.0'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
    }
}
