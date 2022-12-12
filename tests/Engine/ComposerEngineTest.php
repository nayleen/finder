<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Composer\Autoload\ClassLoader;
use Nayleen\Finder\Expectation\Expectation;
use Nayleen\Finder\Expectation\ImplementsInterface;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;

/**
 * @internal
 */
class ComposerEngineTest extends TestCase
{
    /**
     * @test
     */
    public function calls_expectation_when_classes_are_returned(): void
    {
        $classLoader = $this->createMock(ClassLoader::class);
        $classLoader->expects(self::once())->method('getClassMap')->willReturn([stdClass::class => '']);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::once())->method('__invoke')->willReturn(false);

        $engine = new ComposerEngine([$classLoader]);
        $generator = $engine->find($expectation);

        self::assertSame([], iterator_to_array($generator));
    }

    /**
     * @test
     */
    public function can_find_classes_from_global_composer_classloader(): void
    {
        $engine = ComposerEngine::create();
        $expectation = new ImplementsInterface(Throwable::class);
        $generator = $engine->find($expectation);

        self::assertNotCount(0, iterator_to_array($generator));
    }

    /**
     * @test
     */
    public function returns_class_names_meeting_expectation(): void
    {
        $classLoader = $this->createMock(ClassLoader::class);
        $classLoader->expects(self::once())->method('getClassMap')->willReturn([stdClass::class => '']);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::once())->method('__invoke')->willReturn(true);

        $engine = new ComposerEngine([$classLoader]);
        $generator = $engine->find($expectation);

        self::assertSame([stdClass::class], iterator_to_array($generator));
    }

    /**
     * @test
     */
    public function returns_empty_generator_when_classmap_is_empty(): void
    {
        $classLoader = $this->createMock(ClassLoader::class);
        $classLoader->expects(self::once())->method('getClassMap')->willReturn([]);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::never())->method('__invoke');

        $engine = new ComposerEngine([$classLoader]);
        $generator = $engine->find($expectation);

        self::assertSame([], iterator_to_array($generator));
    }
}
