<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Finder\Expectation;

final class Any implements Expectation
{
    public function __invoke(string $class): bool
    {
        return true;
    }
}
