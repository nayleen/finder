<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Composer\Autoload\ClassLoader;
use Nayleen\Finder\Expectation;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
final class ComposerEngineTest extends TestCase
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

        self::assertSame([], [...$generator]);
    }

    /**
     * @test
     */
    public function returns_class_names_meeting_expectation(): void
    {
        $classLoader = $this->createMock(ClassLoader::class);
        $classLoader->expects(self::once())->method('getClassMap')->willReturn([stdClass::class => '']);
        $classLoader->expects(self::once())->method('isClassMapAuthoritative')->willReturn(true);
        $classLoader->expects(self::never())->method('getPrefixesPsr4');
        $classLoader->expects(self::never())->method('getPrefixes');

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::once())->method('__invoke')->willReturn(true);

        $engine = new ComposerEngine([$classLoader]);
        $generator = $engine->find($expectation);

        self::assertSame([stdClass::class], [...$generator]);
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

        self::assertSame([], [...$generator]);
    }

    /**
     * @test
     */
    public function returns_local_class_names_meeting_expectation(): void
    {
        $vfs = vfsStream::setup(structure: [
            'Example.php' => '<?php namespace Acme; class Example {}',
        ]);

        $classLoader = $this->createMock(ClassLoader::class);
        $classLoader->expects(self::once())->method('getClassMap')->willReturn([]);
        $classLoader->expects(self::once())->method('isClassMapAuthoritative')->willReturn(false);
        $classLoader->expects(self::once())->method('getPrefixesPsr4')->willReturn([
            'Acme\\' => [$vfs->url()],
        ]);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::once())->method('__invoke')->willReturn(true);

        $engine = new ComposerEngine([$classLoader]);
        $generator = $engine->find($expectation);

        self::assertSame(['Acme\Example'], [...$generator]);
    }

    /**
     * @test
     */
    public function returns_only_local_class_names_following_psr4(): void
    {
        $vfs = vfsStream::setup(structure: [
            'MismatchedClassName.php' => '<?php namespace Acme; class NameMismatchedClass {}',
        ]);

        $classLoader = $this->createMock(ClassLoader::class);
        $classLoader->expects(self::once())->method('getClassMap')->willReturn([]);
        $classLoader->expects(self::once())->method('isClassMapAuthoritative')->willReturn(false);
        $classLoader->expects(self::once())->method('getPrefixesPsr4')->willReturn([
            'Acme\\' => [$vfs->url()],
        ]);

        $expectation = $this->createMock(Expectation::class);
        $expectation->expects(self::never())->method('__invoke');

        $engine = new ComposerEngine([$classLoader]);
        $generator = $engine->find($expectation);

        self::assertSame([], [...$generator]);
    }
}
