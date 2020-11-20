<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Platform;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\Placeholder\ContextReplacement;
use test\Kiboko\Cloud\Fixture\Placeholder\Regex;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class OroPlatformEnterpriseFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6'], 'oroplatform', ['1.8', '1.10', '1.12'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['5.6', '7.1'], 'oroplatform', ['2.6'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.1', '7.2'], 'oroplatform', ['3.1'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.3', '7.4', '8.0'], 'oroplatform', ['3.1'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
            ->withExperimental()
        ;
        yield (new WizardAssertionFixtureProvider(['7.3'], 'oroplatform', ['4.1'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['7.4'], 'oroplatform', ['4.1', '4.2'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['8.0'], 'oroplatform', ['4.1', '4.2'], true, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ee-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-%applicationVersion%-%dbms%'), '-'],
            )
            ->withExperimental()
        ;
    }
}
