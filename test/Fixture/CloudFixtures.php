<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture;

use test\Kiboko\Cloud\Fixture\Platform;
use test\Kiboko\Cloud\Fixture\Visitor;

trait CloudFixtures
{
    private string $dbms;

    public function useOroCommerceEnterprise()
    {
        yield from (new Platform\OroCommerceEnterpriseFixture($this->dbms))
            ->all();
    }

    public function useOroCommerceEnterpriseWithoutElasticStack()
    {
        yield from (new Platform\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useOroCommerceEnterpriseWithoutXdebug()
    {
        yield from (new Platform\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useOroCommerceEnterpriseWithoutBlackfire()
    {
        yield from (new Platform\OroCommerceEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useOroCommerceCommunity()
    {
        yield from (new Platform\OroCommerceCommunityFixture($this->dbms))
            ->all();
    }

    public function useOroCommerceCommunityWithoutElasticStack()
    {
        yield from (new Platform\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useOroCommerceCommunityWithoutXdebug()
    {
        yield from (new Platform\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useOroCommerceCommunityWithoutBlackfire()
    {
        yield from (new Platform\OroCommerceCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useOroCRMEnterprise()
    {
        yield from (new Platform\OroCRMEnterpriseFixture($this->dbms))
            ->all();
    }

    public function useOroCRMEnterpriseWithoutElasticStack()
    {
        yield from (new Platform\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useOroCRMEnterpriseWithoutXdebug()
    {
        yield from (new Platform\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useOroCRMEnterpriseWithoutBlackfire()
    {
        yield from (new Platform\OroCRMEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useOroCRMCommunity()
    {
        yield from (new Platform\OroCRMCommunityFixture($this->dbms))
            ->all();
    }

    public function useOroCRMCommunityWithoutElasticStack()
    {
        yield from (new Platform\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useOroCRMCommunityWithoutXdebug()
    {
        yield from (new Platform\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useOroCRMCommunityWithoutBlackfire()
    {
        yield from (new Platform\OroCRMCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useOroPlatformEnterprise()
    {
        yield from (new Platform\OroPlatformEnterpriseFixture($this->dbms))
            ->all();
    }

    public function useOroPlatformEnterpriseWithoutElasticStack()
    {
        yield from (new Platform\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useOroPlatformEnterpriseWithoutXdebug()
    {
        yield from (new Platform\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useOroPlatformEnterpriseWithoutBlackfire()
    {
        yield from (new Platform\OroPlatformEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useOroPlatformCommunity()
    {
        yield from (new Platform\OroPlatformCommunityFixture($this->dbms))
            ->all();
    }

    public function useOroPlatformCommunityWithoutElasticStack()
    {
        yield from (new Platform\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useOroPlatformCommunityWithoutXdebug()
    {
        yield from (new Platform\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useOroPlatformCommunityWithoutBlackfire()
    {
        yield from (new Platform\OroPlatformCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useMarelloEnterprise()
    {
        yield from (new Platform\MarelloEnterpriseFixture($this->dbms))
            ->all();
    }

    public function useMarelloEnterpriseWithoutElasticStack()
    {
        yield from (new Platform\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useMarelloEnterpriseWithoutXdebug()
    {
        yield from (new Platform\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useMarelloEnterpriseWithoutBlackfire()
    {
        yield from (new Platform\MarelloEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useMarelloCommunity()
    {
        yield from (new Platform\MarelloCommunityFixture($this->dbms))
            ->all();
    }

    public function useMarelloCommunityWithoutElasticStack()
    {
        yield from (new Platform\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useMarelloCommunityWithoutXdebug()
    {
        yield from (new Platform\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useMarelloCommunityWithoutBlackfire()
    {
        yield from (new Platform\MarelloCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useMiddlewareEnterprise()
    {
        yield from (new Platform\MiddlewareEnterpriseFixture($this->dbms))
            ->all();
    }

    public function useMiddlewareEnterpriseWithoutElasticStack()
    {
        yield from (new Platform\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useMiddlewareEnterpriseWithoutXdebug()
    {
        yield from (new Platform\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useMiddlewareEnterpriseWithoutBlackfire()
    {
        yield from (new Platform\MiddlewareEnterpriseFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useMiddlewareCommunity()
    {
        yield from (new Platform\MiddlewareCommunityFixture($this->dbms))
            ->all();
    }

    public function useMiddlewareCommunityWithoutElasticStack()
    {
        yield from (new Platform\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutElasticStack(),
            );
    }

    public function useMiddlewareCommunityWithoutXdebug()
    {
        yield from (new Platform\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutXdebug(),
            );
    }

    public function useMiddlewareCommunityWithoutBlackfire()
    {
        yield from (new Platform\MiddlewareCommunityFixture($this->dbms))
            ->apply(
                new Visitor\WithoutBlackfire(),
            );
    }

    public function useGeneric()
    {
        yield from $this->useOroCommerceEnterprise();
        yield from $this->useOroCommerceCommunity();
        yield from $this->useOroCRMEnterprise();
        yield from $this->useOroCRMCommunity();
        yield from $this->useOroPlatformEnterprise();
        yield from $this->useOroPlatformCommunity();
        yield from $this->useMarelloEnterprise();
        yield from $this->useMarelloCommunity();
        yield from $this->useMiddlewareEnterprise();
        yield from $this->useMiddlewareCommunity();
    }

    public function useEnterpriseWithoutElasticStack()
    {
        yield from $this->useOroCommerceEnterpriseWithoutElasticStack();
        yield from $this->useOroCRMEnterpriseWithoutElasticStack();
        yield from $this->useOroPlatformEnterpriseWithoutElasticStack();
        yield from $this->useMarelloEnterpriseWithoutElasticStack();
        yield from $this->useMiddlewareEnterpriseWithoutElasticStack();
    }

    public function useCommunityWithoutElasticStack()
    {
        yield from $this->useOroCommerceCommunityWithoutElasticStack();
        yield from $this->useOroCRMCommunityWithoutElasticStack();
        yield from $this->useOroPlatformCommunityWithoutElasticStack();
        yield from $this->useMarelloCommunityWithoutElasticStack();
        yield from $this->useMiddlewareCommunityWithoutElasticStack();
    }

    public function useWithoutElasticStack()
    {
        yield from $this->useOroCommerceEnterpriseWithoutElasticStack();
        yield from $this->useOroCommerceCommunityWithoutElasticStack();
        yield from $this->useOroCRMEnterpriseWithoutElasticStack();
        yield from $this->useOroCRMCommunityWithoutElasticStack();
        yield from $this->useOroPlatformEnterpriseWithoutElasticStack();
        yield from $this->useOroPlatformCommunityWithoutElasticStack();
        yield from $this->useMarelloEnterpriseWithoutElasticStack();
        yield from $this->useMarelloCommunityWithoutElasticStack();
        yield from $this->useMiddlewareEnterpriseWithoutElasticStack();
        yield from $this->useMiddlewareCommunityWithoutElasticStack();
    }

    public function useWithoutXdebug()
    {
        yield from $this->useOroCommerceEnterpriseWithoutXdebug();
        yield from $this->useOroCommerceCommunityWithoutXdebug();
        yield from $this->useOroCRMEnterpriseWithoutXdebug();
        yield from $this->useOroCRMCommunityWithoutXdebug();
        yield from $this->useOroPlatformEnterpriseWithoutXdebug();
        yield from $this->useOroPlatformCommunityWithoutXdebug();
        yield from $this->useMarelloEnterpriseWithoutXdebug();
        yield from $this->useMarelloCommunityWithoutXdebug();
        yield from $this->useMiddlewareEnterpriseWithoutXdebug();
        yield from $this->useMiddlewareCommunityWithoutXdebug();
    }

    public function useWithoutBlackfire()
    {
        yield from $this->useOroCommerceEnterpriseWithoutBlackfire();
        yield from $this->useOroCommerceCommunityWithoutBlackfire();
        yield from $this->useOroCRMEnterpriseWithoutBlackfire();
        yield from $this->useOroCRMCommunityWithoutBlackfire();
        yield from $this->useOroPlatformEnterpriseWithoutBlackfire();
        yield from $this->useOroPlatformCommunityWithoutBlackfire();
        yield from $this->useMarelloEnterpriseWithoutBlackfire();
        yield from $this->useMarelloCommunityWithoutBlackfire();
        yield from $this->useMiddlewareEnterpriseWithoutBlackfire();
        yield from $this->useMiddlewareCommunityWithoutBlackfire();
    }

    public function useAll()
    {
        yield from $this->useGeneric();
//        yield from $this->useWithoutBlackfire();
//        yield from $this->useWithoutElasticStack();
//        yield from $this->useWithoutXdebug();
    }
}
