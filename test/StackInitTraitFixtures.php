<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

trait StackInitTraitFixtures
{
    private string $dbms;


    public function useOroCommerceEnterprise()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceEnterpriseWithoutElasticStack()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceEnterpriseWithoutXdebug()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceEnterpriseWithoutBlackfire()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunity()
    {
        yield from (new Fixture\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithoutElasticStack()
    {
        yield from (new Fixture\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithoutXdebug()
    {
        yield from (new Fixture\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithoutBlackfire()
    {
        yield from (new Fixture\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterprise()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithoutElasticStack()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithoutXdebug()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithoutBlackfire()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunity()
    {
        yield from (new Fixture\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithoutElasticStack()
    {
        yield from (new Fixture\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithoutXdebug()
    {
        yield from (new Fixture\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithoutBlackfire()
    {
        yield from (new Fixture\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterprise()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithoutElasticStack()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithoutXdebug()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithoutBlackfire()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunity()
    {
        yield from (new Fixture\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithoutElasticStack()
    {
        yield from (new Fixture\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithoutXdebug()
    {
        yield from (new Fixture\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithoutBlackfire()
    {
        yield from (new Fixture\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterprise()
    {
        yield from (new Fixture\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithoutElasticStack()
    {
        yield from (new Fixture\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithoutXdebug()
    {
        yield from (new Fixture\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithoutBlackfire()
    {
        yield from (new Fixture\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunity()
    {
        yield from (new Fixture\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithoutElasticStack()
    {
        yield from (new Fixture\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithoutXdebug()
    {
        yield from (new Fixture\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithoutBlackfire()
    {
        yield from (new Fixture\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterprise()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithoutElasticStack()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithoutXdebug()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithoutBlackfire()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunity()
    {
        yield from (new Fixture\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithoutElasticStack()
    {
        yield from (new Fixture\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithoutXdebug()
    {
        yield from (new Fixture\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithoutBlackfire()
    {
        yield from (new Fixture\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }
}
