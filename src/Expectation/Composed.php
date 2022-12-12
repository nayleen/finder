<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class Composed extends AbstractExpectation
{
    public function __construct(
        private readonly Expectation $a,
        private readonly Expectation $b,
    ) {
    }

    public function __invoke(string $class): bool
    {
        return ($this->a)($class) && ($this->b)($class);
    }
}
