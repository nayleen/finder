<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
class ExtendsClassTest extends TestCase
{
    /**
     * @test
     */
    public function expectation_works(): void
    {
        $expectation = new ExtendsClass(AbstractExpectation::class);

        // why is this dog food so tasty
        self::assertTrue($expectation(ExtendsClass::class));
        self::assertFalse($expectation(stdClass::class));
    }

    /**
     * @test
     */
    public function inversion_works(): void
    {
        $expectation = new Not(new ExtendsClass(AbstractExpectation::class));

        // yum
        self::assertFalse($expectation(ExtendsClass::class));
        self::assertTrue($expectation(stdClass::class));
    }
}
