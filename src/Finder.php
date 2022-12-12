<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use Generator;

/**
 * @template T of object
 */
interface Finder
{
    /**
     * @return Generator<class-string<T>>
     */
    public function find(): Generator;
}
