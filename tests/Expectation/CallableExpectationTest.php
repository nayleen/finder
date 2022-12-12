<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
class CallableExpectationTest extends TestCase
{
    /**
     * @test
     */
    public function delegates_to_callable(): void
    {
        $expectation = new CallableExpectation(fn (string $class) => true);

        self::assertTrue($expectation(stdClass::class));
    }
}
