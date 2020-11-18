<?php

use Kiboko\Cloud\Domain\Packaging;

return function(
    Packaging\RepositoryInterface $dbgpRepository,
    Packaging\RepositoryInterface $postgresqlRepository,
    Packaging\RepositoryInterface $phpRepository,
    bool $withExperimental
): iterable {
    yield new Packaging\Native\GenericDockerfile(
        $dbgpRepository,
        new Packaging\Placeholder('native/dbgp/'),
    );

    yield new Packaging\Native\PostgreSQL\Package(
        $postgresqlRepository,
        '9.6',
        new Packaging\Placeholder('postgresql/'),
        $withExperimental
    );

    yield new Packaging\Native\PostgreSQL\Package(
        $postgresqlRepository,
        '10',
        new Packaging\Placeholder('postgresql/'),
        $withExperimental
    );

    yield new Packaging\Native\PostgreSQL\Package(
        $postgresqlRepository,
        '11',
        new Packaging\Placeholder('postgresql/'),
        $withExperimental
    );

    yield new Packaging\Native\PostgreSQL\Package(
        $postgresqlRepository,
        '12',
        new Packaging\Placeholder('postgresql/'),
        $withExperimental
    );

    yield new Packaging\Native\PHP\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\PackageVariation(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('%package.variation%/php/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\PackageVariation(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('%package.variation%/php/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\PackageVariation(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('%package.variation%/php/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\PackageVariation(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('%package.variation%/php/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\PackageVariation(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('%package.variation%/php/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PHP\PackageVariation(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('%package.variation%/php/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '5.6',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.1',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.2',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.3',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('marello/%package.edition%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('middleware/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MiddlewareCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('middleware/%package.edition%/%package.version%/php@%php.version%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MiddlewareCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '7.4',
        new Packaging\Placeholder('middleware/%package.edition%/'),
        new Packaging\Native\PHP\Flavor\StandardFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MiddlewareEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $phpRepository,
        '8.0',
        new Packaging\Placeholder('middleware/%package.edition%/'),
        $withExperimental ?
            new Packaging\Native\PHP\Flavor\StandardFlavorRepository() :
            new Packaging\Native\PHP\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\PHP\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MiddlewareEnterpriseEditionRepository(),
        $withExperimental
    );
};
