<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Visitor;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\FixtureVisitorInterface;
use test\Kiboko\Cloud\Fixture\Placeholder;

final class WithXdebug implements FixtureVisitorInterface
{
    public function __invoke(FixtureProviderInterface $subject): FixtureProviderInterface
    {
        $subject
            ->withXdebug()
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-fpm-xdebug'), '-'],
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-cli-xdebug'), '-'],
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-fpm-xdebug-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Placeholder\Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-cli-xdebug-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Placeholder\Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
        return $subject;
    }
}
