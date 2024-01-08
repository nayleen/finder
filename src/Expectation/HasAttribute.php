<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class HasAttribute extends ReflectionExpectation
{
    /**
     * @param class-string $attribute
     */
    public function __construct(private readonly string $attribute) {}

    public function __invoke(string $class): bool
    {
        return count(self::reflect($class)->getAttributes($this->attribute)) > 0;
    }
}
