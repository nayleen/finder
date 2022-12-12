<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Nayleen\Finder\Expectation\Expectation;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use stdClass;

/**
 * @internal
 */
class BetterReflectionEngineTest extends TestCase
{
    /**
     * @test
     */
    public function calls_expectation_when_sources_are_located(): void
    {
        $reflection = $this->createMock(ReflectionClass::class);
        $reflection->expects(self::once())->method('__toString')->willReturn(stdClass::class);

        $sourceLocator = $this->createMock(SourceLocator::class);
        $sourceLocator->expects(self::once())->method('locateIdentifiersByType')->willReturn([$reflection]);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::once())->method('__invoke')->willReturn(false);

        $engine = new BetterReflectionEngine($sourceLocator);
        $generator = $engine->find($expectation);

        self::assertSame([], iterator_to_array($generator));
    }

    /**
     * @test
     */
    public function returns_class_names_meeting_expectation(): void
    {
        $reflection = $this->createMock(ReflectionClass::class);
        $reflection->expects(self::once())->method('__toString')->willReturn(stdClass::class);

        $sourceLocator = $this->createMock(SourceLocator::class);
        $sourceLocator->expects(self::once())->method('locateIdentifiersByType')->willReturn([$reflection]);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::once())->method('__invoke')->willReturn(true);

        $engine = new BetterReflectionEngine($sourceLocator);
        $generator = $engine->find($expectation);

        self::assertSame([stdClass::class], iterator_to_array($generator));
    }

    /**
     * @test
     */
    public function returns_empty_generator_when_no_sources_are_located(): void
    {
        $sourceLocator = $this->createMock(SourceLocator::class);
        $sourceLocator->expects(self::once())->method('locateIdentifiersByType')->willReturn([]);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::never())->method('__invoke');

        $engine = new BetterReflectionEngine($sourceLocator);
        $generator = $engine->find($expectation);

        self::assertSame([], iterator_to_array($generator));
    }
}
