<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Finder\Expectation\Combinator\Not;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;

/**
 * @internal
 */
class IsInstantiableTest extends TestCase
{
    /**
     * @test
     */
    public function expectation_works(): void
    {
        $expectation = new IsInstantiable();

        self::assertTrue($expectation(stdClass::class));
        self::assertFalse($expectation(Throwable::class));
    }

    /**
     * @test
     */
    public function inversion_works(): void
    {
        $inversion = new Not(new IsInstantiable());

        self::assertFalse($inversion(stdClass::class));
        self::assertTrue($inversion(Throwable::class));
    }
}
