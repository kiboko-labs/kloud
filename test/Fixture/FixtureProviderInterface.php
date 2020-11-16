<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

interface FixtureProviderInterface extends \Traversable
{
    public function getApplication(): string;
    public function isEnterpriseEdition(): bool;
    public function getDBMS(): string;

    public function withBlackfire(): FixtureProviderInterface;
    public function withoutBlackfire(): FixtureProviderInterface;
    public function hasBlackfire(): bool;

    public function withXdebug(): FixtureProviderInterface;
    public function withoutXdebug(): FixtureProviderInterface;
    public function hasXdebug(): bool;

    public function withDejavu(): FixtureProviderInterface;
    public function withoutDejavu(): FixtureProviderInterface;
    public function hasDejavu(): bool;

    public function withElasticStack(): FixtureProviderInterface;
    public function withoutElasticStack(): FixtureProviderInterface;
    public function hasElasticStack(): bool;

    public function withDockerForMacOptimizations(): FixtureProviderInterface;
    public function withoutDockerForMacOptimizations(): FixtureProviderInterface;
    public function hasDockerForMacOptimizations(): bool;

    public function expectWizardMessages(string ...$messages): FixtureProviderInterface;
}
