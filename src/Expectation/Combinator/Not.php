<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation\Combinator;

use Nayleen\Finder\Expectation\AbstractExpectation;
use Nayleen\Finder\Expectation\Expectation;

final class Not extends AbstractExpectation
{
    public function __construct(private readonly Expectation $other)
    {
    }

    public function __invoke(string $class): bool
    {
        return !($this->other)($class);
    }
}
