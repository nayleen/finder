<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use ArrayIterator;
use Nayleen\Finder\Expectation\Any;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FinderTest extends TestCase
{
    /**
     * @test
     */
    public function passes_to_given_engine(): void
    {
        $engine = $this->createMock(Engine::class);
        $engine->expects(self::once())->method('find')->willReturn(new ArrayIterator([]));

        $finder = new class($engine) extends Finder {
            protected function expectation(): Any
            {
                return new Any();
            }
        };

        self::assertSame([], [...$finder]);
    }
}
