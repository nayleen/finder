<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Generator;
use Nayleen\Finder\Expectation\Expectation;

abstract class AbstractEngine implements Engine
{
    /**
     * @return iterable<class-string>
     */
    abstract protected function classes(): iterable;

    /**
     * @return Generator<class-string>
     */
    final public function find(Expectation $expectation): Generator
    {
        foreach ($this->classes() as $class) {
            if ($expectation($class)) {
                yield $class;
            }
        }
    }
}
