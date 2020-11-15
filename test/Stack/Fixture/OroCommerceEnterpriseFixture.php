<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Stack\Fixture;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
use test\Kiboko\Cloud\Stack\WizardAssertionFixtureProvider;

final class OroCommerceEnterpriseFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6'], 'orocommerce', ['1.6'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.1', '7.2'], 'orocommerce', ['3.1'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.3'], 'orocommerce', ['3.1', '4.1'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.4'], 'orocommerce', ['4.1', '4.2'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }
}
