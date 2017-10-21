<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->in(__DIR__."/tests")
;
return \PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
    ->setLineEnding("\n")
    ;
