<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PER-CS' => true,
        '@PER-CS:risky' => true,
        'native_function_invocation' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'no_unused_imports' => true,
        'single_quote' => true,
    ])
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setFinder($finder);
