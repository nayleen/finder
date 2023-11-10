<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class ExtendsClass extends AbstractExpectation
{
    /**
     * @param class-string $expectedClass
     */
    public function __construct(private readonly string $expectedClass) {}

    public function __invoke(string $class): bool
    {
        return is_subclass_of($class, $this->expectedClass);
    }
}
