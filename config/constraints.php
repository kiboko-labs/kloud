<?php

use Kiboko\Cloud\Domain\Assert;
use Kiboko\Cloud\Domain\Packaging;

$repository = new Packaging\Repository('kiboko/php');

return [
    new Assert\CLI($repository),
    new Assert\FPM($repository),

    new Assert\NodeJS($repository, '^8.14', '/^5\.\d+-cli(?:$|-)/'),
    new Assert\NodeJS($repository, '^10.19', '/^7\.1-cli(?:$|-)/'),
    new Assert\NodeJS($repository, '^12.15', '/^7\.[234]-cli(?:$|-)/'),
    new Assert\NodeJS($repository, '^16.16', '/^8\.[01]-cli(?:$|-)/'),

    new Assert\NPM($repository, '^6.4', '/^5\.\d+-cli(?:$|-)/'),
    new Assert\NPM($repository, '^6.13', '/^7\.[1234]-cli(?:$|-)/'),
    new Assert\NPM($repository, '^7.10', '/^8\.[01]-cli(?:$|-)/'),

    new Assert\ComposerVersion($repository, '~2.2'),

    new Assert\BlackfireVersion($repository, '~2.0'),

    new Assert\CSFixerVersion($repository, '~2.16', '/-cli(?:$|-)/'),

    new Assert\PHPUnitVersion($repository, '~7.5', '/^7\.1-cli(?:$|-)/'),
    new Assert\PHPUnitVersion($repository, '~8.5', '/^7\.[234]-cli(?:$|-)/'),
    new Assert\PHPUnitVersion($repository, '~9.5', '/^8\.[01]-cli(?:$|-)/'),

    new Assert\PHPSpecVersion($repository, '~5.1', '/^7\.1-cli(?:$|-)/'),
    new Assert\PHPSpecVersion($repository, '~6.1', '/^7\.[234]-cli(?:$|-)/'),
    new Assert\PHPSpecVersion($repository, '~6.2', '/^8\.[01]-cli(?:$|-)/'),

    new Assert\InfectionVersion($repository, '~0.13', '/^7\.[1234]-cli(?:$|-)/'),
    new Assert\InfectionVersion($repository, '~0.26', '/^8\.[01]-cli(?:$|-)/'),

    new Assert\PHPExtensionVersion($repository, 'blackfire', '^1.31', '/-blackfire(?:$|-)/'),
//    new Assert\PHPExtensionVersion($repository, 'blackfire', '~2.0', '/^8\.1-.*-blackfire(?:$|-)/'),

    new Assert\PHPExtensionVersion($repository, 'xdebug', '^2.5', '/^5\.\d-(?:cli|fpm)-xdebug(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'xdebug', '^2.9', '/^7\.\d-(?:cli|fpm)-xdebug(?:$|-)/'),
    new Assert\PHPExtensionVersion($repository, 'xdebug', '^3.1', '/^8\.\d-(?:cli|fpm)-xdebug(?:$|-)/'),

    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.1', '/^7\.1-.*-postgresql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.2', '/^7\.2-.*-postgresql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.3', '/^7\.3-.*-postgresql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^7.4', '/^7\.4-.*-postgresql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_pgsql', '^8.1', '/^8\.1-.*-postgresql$/'),

    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.1', '/^7\.1-.*-mysql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.2', '/^7\.2-.*-mysql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.3', '/^7\.3-.*-mysql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^7.4', '/^7\.4-.*-mysql$/'),
    new Assert\PHPExtensionVersion($repository, 'pdo_mysql', '^8.1', '/^8\.1-.*-mysql$/'),

    new Assert\PHPExtensionVersion($repository, 'ctype', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'curl', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'fileinfo', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'gd', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'intl', '*', '/-[ce]e-\d+\.\d+-/'), // (ICU library 4.4 and above)
    new Assert\PHPExtensionVersion($repository, 'json', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'mbstring', '*', '/-[ce]e-\d+\.\d+-/'),
//    new Assert\PHPExtensionVersion($repository, 'sodium', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'openssl', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'pcre', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'simplexml', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'tokenizer', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'xml', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'zip', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'imap', '*', '/-[ce]e-\d+\.\d+-/'),
//    new Assert\PHPExtensionVersion($repository, 'soap', '*', '/-[ce]e-\d+\.\d+-/'),
//    new Assert\PHPExtensionVersion($repository, 'bcmath', '*', '/-[ce]e-\d+\.\d+-/'),
//    new Assert\PHPExtensionVersion($repository, 'ldap', '*', '/-[ce]e-\d+\.\d+-/'),
    new Assert\PHPExtensionVersion($repository, 'pcntl', '*', '/(?:(?:oroplatform|orocommerce|orocrm)-[ce]e-4\.\d+-|marello-[ce]e-3\.\d+|middleware-[ce]e-1\.\d+)/'),
    new Assert\PHPExtensionVersion($repository, 'zmq', '*', '/(?:middleware-[ce]e-1\.\d+-)/'),
    new Assert\PHPExtensionVersion($repository, 'rdkafka', '*', '/(?:middleware-[ce]e-1\.\d+-)/'),

    new Assert\ICUVersion($repository, '>=4.4', '/-[ce]e-\d+\.\d+-/'),
];
