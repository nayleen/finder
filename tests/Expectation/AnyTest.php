<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Finder\Expectation\Combinator\Not;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
final class AnyTest extends TestCase
{
    /**
     * @test
     */
    public function expectation_works(): void
    {
        $expectation = new Any();

        self::assertTrue($expectation(stdClass::class));
    }

    /**
     * @test
     */
    public function inversion_works(): void
    {
        $expectation = new Not(new Any());

        self::assertFalse($expectation(stdClass::class));
    }
}
