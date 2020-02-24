<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('Resources')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PHP71Migration' => true,
        '@PHP73Migration' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'pow_to_exponentiation' => true,
        'pre_increment' => true,
        'protected_to_private' => true,
        'psr4' => true,
        'phpdoc_var_without_name' => true,
        'phpdoc_line_span' => [
            'property' => 'single',
            'method' => 'multi',
            'const' => 'single',
        ],
    ])
    ->setFinder($finder)
;
