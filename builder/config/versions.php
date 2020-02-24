<?php

use Builder\Package\Repository;
use Builder\PHP;

$repository = new Repository('kiboko/php');

return [

    new PHP\BuildableVersion(
        $repository,
        '7.1',
        '/environments/native/php@%php.version%/%php.flavor%/',
        new PHP\Flavor('cli'),
        new PHP\Flavor('cli-blackfire'),
        new PHP\Flavor('cli-xdebug'),
        new PHP\Flavor('fpm'),
        new PHP\Flavor('fpm-blackfire'),
        new PHP\Flavor('fpm-xdebug'),
    ),

    new PHP\BuildableVersion(
        $repository,
        '7.2',
        '/environments/native/php@%php.version%/%php.flavor%/',
        new PHP\Flavor('cli'),
        new PHP\Flavor('cli-blackfire'),
        new PHP\Flavor('cli-xdebug'),
        new PHP\Flavor('fpm'),
        new PHP\Flavor('fpm-blackfire'),
        new PHP\Flavor('fpm-xdebug'),
    ),

    new PHP\BuildableVersion(
        $repository,
        '7.3',
        '/environments/native/php@%php.version%/%php.flavor%/',
        new PHP\Flavor('cli'),
        new PHP\Flavor('cli-blackfire'),
        new PHP\Flavor('cli-xdebug'),
        new PHP\Flavor('fpm'),
        new PHP\Flavor('fpm-blackfire'),
        new PHP\Flavor('fpm-xdebug'),
    ),

    new PHP\BuildableVersion(
        $repository,
        '7.4',
        '/environments/native/php@%php.version%/%php.flavor%/',
        new PHP\Flavor('cli'),
        new PHP\Flavor('cli-blackfire'),
        new PHP\Flavor('cli-xdebug'),
        new PHP\Flavor('fpm'),
        new PHP\Flavor('fpm-blackfire'),
        new PHP\Flavor('fpm-xdebug'),
    ),

    new PHP\BuildableVersion(
        $repository,
        '8.0',
        '/environments/native/php@%php.version%/%php.flavor%/',
        new PHP\Flavor('cli'),
//        new PHP\Flavor('cli-blackfire'),
//        new PHP\Flavor('cli-xdebug'),
        new PHP\Flavor('fpm'),
//        new PHP\Flavor('fpm-blackfire'),
//        new PHP\Flavor('fpm-xdebug'),
    ),
];
