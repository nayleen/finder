<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation\Combinator;

use Nayleen\Finder\Expectation\CallableExpectation;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
class NotTest extends TestCase
{
    /**
     * @test
     */
    public function negates_inner_expectation(): void
    {
        $negated = new Not(new CallableExpectation(fn (string $class) => true));

        self::assertFalse($negated(stdClass::class));
    }
}
