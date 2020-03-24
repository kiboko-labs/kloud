<?php

declare(strict_types=1);

namespace Kiboko\Cloud\PHPSpec;

use PhpSpec\Extension;
use PhpSpec\ServiceContainer;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

final class BuilderExtension implements Extension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('matchers.should_iterate_with_tags_like', function (IndexedServiceContainer $c) {
            return new Matcher\ShouldIterateWithTagsLike($c->get('formatter.presenter'));
        }, ['matchers']);
        $container->define('matchers.should_iterate_with_buildable_tags_like', function (IndexedServiceContainer $c) {
            return new Matcher\ShouldIterateWithBuildableTagsLike($c->get('formatter.presenter'));
        }, ['matchers']);
    }
}
