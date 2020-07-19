<?php

use Kiboko\Cloud\Domain\Packaging;

return function(bool $withExperimental): iterable {
    $repository = new Packaging\Repository('kiboko/php');

    yield new Packaging\Native\Package(
        $repository,
        '5.6',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\Package(
        $repository,
        '8.0',
        new Packaging\Placeholder('native/php@%php.version%/%php.flavor%/'),
        new Packaging\Native\Flavor\ExperimentalFlavorRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PackageVariation(
        $repository,
        '5.6',
        new Packaging\Placeholder('%package.variation%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PackageVariation(
        $repository,
        '7.1',
        new Packaging\Placeholder('%package.variation%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PackageVariation(
        $repository,
        '7.2',
        new Packaging\Placeholder('%package.variation%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PackageVariation(
        $repository,
        '7.3',
        new Packaging\Placeholder('%package.variation%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PackageVariation(
        $repository,
        '7.4',
        new Packaging\Placeholder('%package.variation%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Native\PackageVariation(
        $repository,
        '8.0',
        new Packaging\Placeholder('%package.variation%/'),
        new Packaging\Native\Flavor\ExperimentalFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '5.6',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('oroplatform/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '5.6',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('oroplatform/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroPlatformEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('orocommerce/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('orocommerce/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCommerceEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('orocrm/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('orocrm/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\OroCRMEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('marello/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloCommunityEditionRepository()
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.1',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.2',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.3',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('marello/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MarelloEnterpriseEditionRepository(),
        $withExperimental
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('middleware/%package.edition%/%package.version%/php@%php.version%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MiddlewareCommunityEditionRepository()
    );

    yield new Packaging\Platform\Package(
        $repository,
        '7.4',
        new Packaging\Placeholder('middleware/%package.edition%/'),
        new Packaging\Native\Flavor\StandardFlavorRepository(),
        new Packaging\Native\Variation\StandardVariationRepository(),
        new Packaging\Platform\Edition\MiddlewareEnterpriseEditionRepository()
    );
};