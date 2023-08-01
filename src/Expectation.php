<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

interface Expectation
{
    /**
     * @param class-string $class
     */
    public function __invoke(string $class): bool;
}
