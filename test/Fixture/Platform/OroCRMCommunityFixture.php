<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Platform;

use test\Kiboko\Cloud\Fixture\FixtureInterface;
use test\Kiboko\Cloud\Fixture\Placeholder\ContextReplacement;
use test\Kiboko\Cloud\Fixture\Placeholder\Regex;
use test\Kiboko\Cloud\Fixture\VisitableFixture;
use test\Kiboko\Cloud\WizardAssertionFixtureProvider;

final class OroCRMCommunityFixture implements FixtureInterface
{
    use VisitableFixture;

    private string $dbms;

    public function __construct(string $dbms)
    {
        $this->dbms = $dbms;
    }

    public function get(): iterable
    {
        yield (new WizardAssertionFixtureProvider(['5.6'], 'orocrm', ['1.6', '1.8', '1.10'], false, $this->dbms))
            ->expectWizardMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
            ->expectImageBuildProcesses(
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
            )
        ;
//        yield (new WizardAssertionFixtureProvider(['5.6', '7.1'], 'orocrm', ['2.6'], false, $this->dbms))
//            ->expectWizardMessages(
//                'Choosing OroCRM Community Edition, version %applicationVersion%.',
//            )
//            ->expectImageBuildProcesses(
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//            )
//        ;
//        yield (new WizardAssertionFixtureProvider(['7.1', '7.2'], 'orocrm', ['3.1'], false, $this->dbms))
//            ->expectWizardMessages(
//                'Choosing OroCRM Community Edition, version %applicationVersion%.',
//            )
//            ->expectImageBuildProcesses(
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//            )
//        ;
//        yield (new WizardAssertionFixtureProvider(['7.3', '7.4', '8.0'], 'orocrm', ['3.1'], false, $this->dbms))
//            ->expectWizardMessages(
//                'Choosing OroCRM Community Edition, version %applicationVersion%.',
//            )
//            ->expectImageBuildProcesses(
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//            )
//            ->withExperimental()
//        ;
//        yield (new WizardAssertionFixtureProvider(['7.3', '7.4'], 'orocrm', ['4.1', '4.2'], false, $this->dbms))
//            ->expectWizardMessages(
//                'Choosing OroCRM Community Edition, version %applicationVersion%.',
//            )
//            ->expectImageBuildProcesses(
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//            )
//        ;
//        yield (new WizardAssertionFixtureProvider(['8.0'], 'orocrm', ['4.1', '4.2'], false, $this->dbms))
//            ->expectWizardMessages(
//                'Choosing OroCRM Community Edition, version %applicationVersion%.',
//            )
//            ->expectImageBuildProcesses(
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-fpm-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//                ['docker', 'build', '--rm', '--tag', new ContextReplacement('kiboko-test/php:%phpVersion%-cli-%application%-%applicationEdition%-%applicationVersion%-%dbms%'), '--build-arg', new Regex('/^SOURCE_VARIATION=/'), '-'],
//            )
//            ->withExperimental()
//        ;
    }
}
