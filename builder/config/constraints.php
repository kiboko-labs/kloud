<?php

use Builder\Assert;
use Builder\Package\Repository;

$repository = new Repository('kiboko/php');

return [

    new Assert\ComposerVersion($repository, '^1.9'),

    new Assert\BlackfireVersion($repository, '^1.32'),

    new Assert\PHPExtensionVersion($repository, 'blackfire', '^1.31', '/-blackfire(?:$|-)/'),

    new Assert\PHPExtensionVersion($repository, 'xdebug', '^2.9', '/-xdebug(?:$|-)/'),

    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.1', '/^7\.1-.*-postgresql(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.2', '/^7\.2-.*-postgresql(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.3', '/^7\.3-.*-postgresql(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.4', '/^7\.4-.*-postgresql(?:$|-)/'),

    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.1', '/^7\.1-.*-mysql(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.2', '/^7\.2-.*-mysql(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.3', '/^7\.3-.*-mysql(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.4', '/^7\.4-.*-mysql(?:$|-)/'),

];