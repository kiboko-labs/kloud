<?php

use Builder\Package;
use Builder\Package\Repository;

$versions = require 'versions.php';

$repository = new Repository('kiboko/php');

$postgres = new Package\BuildableVariation(
    $repository,
    'postgresql',
    '/environments/%package.variation%/',
    ...$versions
);
$mysql = new Package\BuildableVariation(
    $repository,
    'mysql',
    '/environments/%package.variation%/',
    ...$versions
);

return [
    $postgres,
    $mysql,

    new Package\BuildablePackage(
        $repository,
        'oroplatform',
        null,
        new Package\BuildableEdition(
            $repository,
            'ce',
            '/environments/oroplatform/%package.edition%/%package.version%/%package.variation%/php@%php.version%/',
//            new Package\Version('1.6', $postgres, $mysql),
            new Package\Version('3.1', $postgres, $mysql),
            new Package\Version('4.1', $postgres, $mysql)
        ),
        new Package\BuildableDependentEdition(
            $repository,
            'ee',
            'ce',
            '/environments/oroplatform/%package.edition%/',
//            new Package\Version('1.6', $postgres, $mysql),
            new Package\Version('3.1', $postgres, $mysql),
            new Package\Version('4.1', $postgres, $mysql)
        )
    ),

    new Package\BuildableDependentPackage(
        $repository,
        'orocrm',
        'oroplatform',
        '/environments/orocrm/%package.edition%/%package.version%/%package.variation%/php@%php.version%/',
        new Package\Edition(
            'ce',
//            new Package\Version('1.6', $postgres, $mysql),
            new Package\Version('3.1', $postgres, $mysql),
            new Package\Version('4.1', $postgres, $mysql)
        ),
        new Package\BuildableDependentEdition(
            $repository,
            'ee',
            'ce',
            '/environments/orocommerce/%package.edition%/',
//            new Package\Version('1.6', $postgres, $mysql),
            new Package\Version('3.1', $postgres, $mysql),
            new Package\Version('4.1', $postgres, $mysql)
        )
    ),

    new Package\BuildableDependentPackage(
        $repository,
        'orocommerce',
        'oroplatform',
        null,
        new Package\BuildableEdition(
            $repository,
            'ce',
            '/environments/orocommerce/%package.edition%/%package.version%/%package.variation%/php@%php.version%/',
//            new Package\Version('1.6', $postgres, $mysql),
            new Package\Version('3.1', $postgres, $mysql),
            new Package\Version('4.1', $postgres, $mysql)
        ),
        new Package\BuildableDependentEdition(
            $repository,
            'ee',
            'ce',
            '/environments/orocommerce/%package.edition%/',
//            new Package\Version('1.6', $postgres, $mysql),
            new Package\Version('3.1', $postgres, $mysql),
            new Package\Version('4.1', $postgres, $mysql)
        )
    ),

//    new Package\BuildableDependentPackage(
//        $repository,
//        'marello',
//        'oroplatform',
//        '/environments/orocommerce/%package.edition%/%package.version%/%package.variation%/php@%php.version%/',
//        new Package\Edition(
//            'ce',
//            new Package\Version('1.6', $postgres, $mysql),
//            new Package\Version('3.1', $postgres, $mysql),
//            new Package\Version('4.1', $postgres, $mysql)
//        ),
//        new Package\BuildableDependentEdition(
//            $repository,
//            'ee',
//            'ce',
//            '/environments/orocommerce/%package.edition%/',
//            new Package\Version('1.5', $postgres, $mysql),
//            new Package\Version('2.0', $postgres, $mysql),
//            new Package\Version('2.1', $postgres, $mysql),
//            new Package\Version('2.2', $postgres, $mysql),
//            new Package\Version('3.0', $postgres, $mysql)
//        )
//    ),
];