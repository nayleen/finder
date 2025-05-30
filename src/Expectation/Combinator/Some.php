<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation\Combinator;

use Nayleen\Finder\Expectation;
use Nayleen\Finder\Expectation\AbstractExpectation;

final class Some extends AbstractExpectation
{
    public function __construct(
        private readonly Expectation $a,
        private readonly Expectation $b,
    ) {}

    public function __invoke(string $class): bool
    {
        return ($this->a)($class) || ($this->b)($class);
    }
}
