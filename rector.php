<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Php84\Rector\MethodCall\NewMethodCallWithoutParenthesesRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
                ->withPaths([
                    __DIR__ . '/src',
                ])
                ->withSkip([
                    NewMethodCallWithoutParenthesesRector::class,
                    UnusedForeachValueToArrayKeysRector::class,
                    RemoveUnusedForeachKeyRector::class,
                    RemoveUselessParamTagRector::class,
                    RemoveUselessReturnTagRector::class,
                    SimplifyUselessVariableRector::class,
                    RenamePropertyToMatchTypeRector::class,
                    RenameVariableToMatchMethodCallReturnTypeRector::class,
                    NewlineAfterStatementRector::class,
                    RemoveUnusedPrivateMethodRector::class,
                    RenameParamToMatchTypeRector::class,
                    RenameVariableToMatchNewTypeRector::class,
                ])
                ->withPreparedSets(
                //deadCode: true,
                //codeQuality: true,
                codingStyle: true,
                naming: true,
                privatization: true,
                //typeDeclarations: true,
                rectorPreset: true
                )
                ->withPhpSets(php84: true)
                ->withPhpVersion(PhpVersion::PHP_84)
                ->withAttributesSets(symfony: true, doctrine: true)
                ->withComposerBased(twig: true, doctrine: true, phpunit: true, symfony: true)
                ->withSets(
                        [
                            LevelSetList::UP_TO_PHP_84
                        ]
                )
                ->withRules(
                        [
                        //ExplicitNullableParamTypeRector::class,
                        //AddOverrideAttributeToOverriddenMethodsRector::class,
                        //ReturnTypeFromStrictNativeCallRector::class
                        ]
                )
                ->withTypeCoverageLevel(50)
                ->withDeadCodeLevel(50)
                ->withCodeQualityLevel(50)
;
