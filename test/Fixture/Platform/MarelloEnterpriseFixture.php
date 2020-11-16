<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Platform;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\Placeholder\ContextReplacement;
use test\Kiboko\Cloud\Fixture\Placeholder\Regex;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class MarelloEnterpriseFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6'], 'marello', ['1.5', '1.6'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
            ->expectProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.1', '7.2'], 'marello', ['1.5', '1.6', '2.0', '2.1', '2.2'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
            ->expectProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.3'], 'marello', ['2.0', '2.1', '2.2', '3.0'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
            ->expectProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.4'], 'marello', ['3.0'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
            ->expectProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
    }
}
