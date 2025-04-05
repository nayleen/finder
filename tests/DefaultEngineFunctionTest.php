<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use Nayleen\Finder\Engine\ComposerEngine;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @backupStaticAttributes
 */
final class DefaultEngineFunctionTest extends TestCase
{
    /**
     * @test
     */
    public function can_fetch_default_engine(): void
    {
        self::assertInstanceOf(ComposerEngine::class, defaultEngine());
    }

    /**
     * @test
     */
    public function can_set_default_engine(): void
    {
        $engine = defaultEngine(ComposerEngine::class);
        self::assertInstanceOf(ComposerEngine::class, $engine);
    }
}
