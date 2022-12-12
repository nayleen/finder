<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Generator;
use Nayleen\Finder\Expectation\Expectation;

/**
 * @template T of object
 */
interface Engine
{
    /**
     * @return Generator<class-string<T>>
     */
    public function find(Expectation $expectation): Generator;
}
