<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Finder\Expectation;
use Nayleen\Finder\Expectation\Combinator\Composed;
use Nayleen\Finder\Expectation\Combinator\Some;

abstract class AbstractExpectation implements Expectation
{
    final public function and(Expectation $other): Composed
    {
        return new Composed($this, $other);
    }

    final public function or(Expectation $other): Some
    {
        return new Some($this, $other);
    }
}
