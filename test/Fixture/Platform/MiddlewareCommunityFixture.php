<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Platform;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\Placeholder\ContextReplacement;
use test\Kiboko\Cloud\Fixture\Placeholder\Regex;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
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
            ->expectWizardMessages(
                'Choosing Middleware Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-4.1-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-middleware-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-4.1-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-4.1-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-middleware-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-4.1-%dbms%'), '-'],
            )
        ;
        yield (new WizardAssertionFixtureProvider(['8.0'], 'middleware', ['1.0'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing Middleware Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-oroplatform-ce-4.1-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-middleware-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-fpm-oroplatform-ce-4.1-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-oroplatform-ce-4.1-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-%dbms%'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-middleware-ce-%applicationVersion%-%dbms%'), '--build-arg', new ContextReplacement('SOURCE_VARIATION=%phpVersion%-cli-oroplatform-ce-4.1-%dbms%'), '-'],
            )
            ->withExperimental()
        ;
    }
}
