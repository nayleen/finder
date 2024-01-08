<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Attribute;
use Nayleen\Finder\Expectation\Combinator\Not;
use PHPUnit\Framework\TestCase;
use stdClass;

#[Attribute(Attribute::TARGET_CLASS)]
class TestAttribute
{
    public function __construct(public ?string $value = null) {}
}

#[TestAttribute]
class TestClass {}

/**
 * @internal
 */
final class HasAttributeTest extends TestCase
{
    /**
     * @test
     */
    public function expectation_works(): void
    {
        $expectation = new HasAttribute(TestAttribute::class);

        self::assertTrue($expectation(TestClass::class));
        self::assertFalse($expectation(stdClass::class));
    }

    /**
     * @test
     */
    public function inversion_works(): void
    {
        $expectation = new Not(new HasAttribute(TestAttribute::class));

        self::assertFalse($expectation(TestClass::class));
        self::assertTrue($expectation(stdClass::class));
    }
}
