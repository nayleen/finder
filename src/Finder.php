<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use IteratorAggregate;
use Nayleen\Finder\Engine\CachedEngine;
use Traversable;

/**
 * @template-covariant T of object
 * @template-implements IteratorAggregate<class-string<T>>
 */
abstract class Finder implements IteratorAggregate
{
    /**
     * @param Engine<T> $engine
     */
    public function __construct(private readonly Engine $engine = new CachedEngine()) {}

    abstract protected function expectation(): Expectation;

    final public function getIterator(): Traversable
    {
        return yield from $this->engine->find($this->expectation());
    }
}
