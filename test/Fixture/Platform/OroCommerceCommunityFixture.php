<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Platform;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\Placeholder\ContextReplacement;
use test\Kiboko\Cloud\Fixture\Placeholder\Regex;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class OroCommerceCommunityFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6', '7.1'], 'orocommerce', ['1.6'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-2.6-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-2.6-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-2.6-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-2.6-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.1', '7.2'], 'orocommerce', ['3.1'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.3', '7.4', '8.0'], 'orocommerce', ['3.1'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
            ->withExperimental()
        ;
        yield (new WizardAssertionFixtureProvider(['7.3'], 'orocommerce', ['4.1'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.4'], 'orocommerce', ['4.1', '4.2'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['8.0'], 'orocommerce', ['4.1', '4.2'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-orocommerce-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
            ->withExperimental()
        ;
    }
}
