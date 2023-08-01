<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Nayleen\Finder\Engine;
use Nayleen\Finder\Expectation;

/**
 * @template-covariant T of object
 * @template-implements Engine<T>
 */
abstract class AbstractEngine implements Engine
{
    /**
     * @return iterable<class-string<T>>
     */
    abstract protected function classes(): iterable;

    /**
     * @return iterable<class-string<T>>
     */
    final public function find(Expectation $expectation): iterable
    {
        foreach ($this->classes() as $class) {
            if ($expectation($class)) {
                yield $class;
            }
        }
    }
}
