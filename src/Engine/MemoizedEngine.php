<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Nayleen\Finder\Engine;
use Nayleen\Finder\Expectation\Any;

/**
 * @template-covariant T of object
 * @template-extends AbstractEngine<T>
 */
final class MemoizedEngine extends AbstractEngine
{
    /**
     * @var class-string<T>[]
     */
    private array $cache;

    /**
     * @param Engine<T> $other
     */
    public function __construct(private readonly Engine $other) {}

    /**
     * @return iterable<class-string<T>>
     */
    private function delegate(): iterable
    {
        if ($this->other instanceof AbstractEngine) {
            $classes = $this->other->classes();

            /**
             * @var iterable<class-string<T>> $classes
             */
            return $classes;
        }

        return $this->other->find(new Any());
    }

    /**
     * @return iterable<class-string<T>>
     */
    protected function classes(): iterable
    {
        if (isset($this->cache)) {
            return yield from $this->cache;
        }

        $this->cache = [];

        foreach ($this->delegate() as $class) {
            yield $this->cache[] = $class;
        }
    }
}
