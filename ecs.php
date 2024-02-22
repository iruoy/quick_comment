<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ])
    ->withPhpCsFixerSets(
        php83Migration: true,
        symfony: true,
    )
    ->withPreparedSets(
        psr12: true,
        common: true,
        symplify: true,
        strict: true,
        cleanCode: true,
    )
    ->withSkip([
        ArrayOpenerAndCloserNewlineFixer::class,
        PhpdocToCommentFixer::class,
        StandaloneLineInMultilineArrayFixer::class,
    ])
;
