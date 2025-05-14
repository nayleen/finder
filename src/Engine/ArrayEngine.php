<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

/**
 * @template-covariant T of object
 * @template-extends AbstractEngine<T>
 */
final class ArrayEngine extends AbstractEngine
{
    /**
     * @param iterable<class-string<T>> $classes
     */
    public function __construct(private readonly iterable $classes) {}

    /**
     * @return iterable<class-string<T>>
     */
    protected function classes(): iterable
    {
        return $this->classes;
    }
}
