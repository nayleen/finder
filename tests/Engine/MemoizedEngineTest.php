<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Nayleen\Finder\Engine;
use Nayleen\Finder\Expectation\Any;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
final class MemoizedEngineTest extends TestCase
{
    /**
     * @test
     */
    public function only_calls_delegate_once(): void
    {
        $delegateEngine = $this->createMock(Engine::class);
        $delegateEngine->expects(self::once())->method('find')->willReturn([
            stdClass::class,
        ]);

        $engine = new MemoizedEngine($delegateEngine);
        self::assertSame([stdClass::class], [...$engine->find(new Any())]);
        self::assertSame([stdClass::class], [...$engine->find(new Any())]);
    }

    /**
     * @test
     */
    public function taps_classes_directly_from_abstract_engine_delegate(): void
    {
        $delegateEngine = $this->createMock(AbstractEngine::class);
        $delegateEngine->expects(self::once())->method('classes')->willReturn([
            stdClass::class,
        ]);

        $engine = new MemoizedEngine($delegateEngine);
        self::assertSame([stdClass::class], [...$engine->find(new Any())]);
    }
}
