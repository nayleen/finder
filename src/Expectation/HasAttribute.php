<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Attribute\AttributeValueGetter;

final class HasAttribute extends ReflectionExpectation
{
    private const ATTR_NULL_VALUE = '__' . __CLASS__ . '_NULL';

    /**
     * @param class-string $attribute
     */
    public function __construct(
        private readonly string $attribute,
        private readonly mixed $expectedValue = null,
    ) {}

    public function __invoke(string $class): bool
    {
        $value = AttributeValueGetter::get($class, $this->attribute, self::ATTR_NULL_VALUE);

        if (isset($this->expectedValue)) {
            return $value === $this->expectedValue;
        }

        return $value !== self::ATTR_NULL_VALUE;
    }
}
