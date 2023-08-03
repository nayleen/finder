<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use IteratorAggregate;
use Traversable;

/**
 * @template-covariant T of object
 * @template-implements IteratorAggregate<class-string<T>>
 */
abstract class Finder implements IteratorAggregate
{
    /**
     * @var Engine<T>
     */
    private readonly Engine $engine;

    public function __construct(?Engine $engine = null)
    {
        $engine ??= defaultEngine();

        /**
         * @var Engine<T> $engine
         */
        $this->engine = $engine;
    }

    abstract protected function expectation(): Expectation;

    final public function getIterator(): Traversable
    {
        return yield from $this->engine->find($this->expectation());
    }
}
