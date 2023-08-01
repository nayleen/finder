<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

/**
 * @template-covariant T of object
 */
interface Engine
{
    /**
     * @return iterable<class-string<T>>
     */
    public function find(Expectation $expectation): iterable;
}
