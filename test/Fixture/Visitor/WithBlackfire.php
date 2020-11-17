<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Visitor;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\FixtureVisitorInterface;
use test\Kiboko\Cloud\Fixture\Placeholder;

final class WithBlackfire implements FixtureVisitorInterface
{
    public function __invoke(FixtureProviderInterface $subject): FixtureProviderInterface
    {
        $subject
            ->withBlackfire()
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-fpm-blackfire'), '-'],
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-cli-blackfire'), '-'],
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-fpm-blackfire-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Placeholder\Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new Placeholder\ContextReplacement('kiboko-test/php:%phpVersion%-cli-blackfire-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Placeholder\Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
        return $subject;
    }
}
