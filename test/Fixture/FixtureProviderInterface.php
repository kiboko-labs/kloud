<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

interface FixtureProviderInterface extends \Traversable
{
    public function withBlackfire(): FixtureProviderInterface;

    public function withoutBlackfire(): FixtureProviderInterface;

    public function withXdebug(): FixtureProviderInterface;

    public function withoutXdebug(): FixtureProviderInterface;

    public function withDejavu(): FixtureProviderInterface;

    public function withoutDejavu(): FixtureProviderInterface;

    public function withElasticStack(): FixtureProviderInterface;

    public function withoutElasticStack(): FixtureProviderInterface;

    public function withDockerForMacOptimizations(): FixtureProviderInterface;

    public function withoutDockerForMacOptimizations(): FixtureProviderInterface;

    public function expectWizardMessages(string ...$messages): FixtureProviderInterface;
}
