<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Generator;
use Nayleen\Finder\Expectation\Expectation;

/**
 * @template T of object
 */
abstract class AbstractEngine implements Engine
{
    /**
     * @return iterable<class-string<T>>
     */
    abstract protected function classes(): iterable;

    /**
     * @return Generator<class-string<T>>
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
