<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation\Combinator;

use Nayleen\Finder\Expectation\CallableExpectation;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 */
final class ComposedTest extends TestCase
{
    /**
     * @test
     */
    public function delegates_to_inner_expectations(): void
    {
        $inner = new CallableExpectation(fn (string $class) => true);
        $composed = $inner->and($inner);

        self::assertTrue($composed(stdClass::class));
    }
}
