<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
class ImplementsInterfaceTest extends TestCase
{
    /**
     * @test
     */
    public function expectation_works(): void
    {
        $expectation = new ImplementsInterface(Expectation::class);

        // this might be my tastiest dog food yet
        self::assertTrue($expectation(ImplementsInterface::class));
        self::assertFalse($expectation(stdClass::class));
    }

    /**
     * @test
     */
    public function inversion_works(): void
    {
        $expectation = new Not(new ImplementsInterface(Expectation::class));

        // still mighty tasty
        self::assertFalse($expectation(ImplementsInterface::class));
        self::assertTrue($expectation(stdClass::class));
    }
}
