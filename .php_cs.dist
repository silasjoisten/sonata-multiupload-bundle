<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'psr4' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;