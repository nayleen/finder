<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use Nayleen\Finder\Engine\BetterReflectionEngine;
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
        self::assertInstanceOf(BetterReflectionEngine::class, defaultEngine());
    }

    /**
     * @test
     */
    public function can_set_default_engine(): void
    {
        $engine = defaultEngine(BetterReflectionEngine::class);
        self::assertInstanceOf(BetterReflectionEngine::class, $engine);
    }
}
