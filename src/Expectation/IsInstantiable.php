<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class IsInstantiable extends ReflectionExpectation
{
    public function __invoke(string $class): bool
    {
        return $this->reflect($class)->isInstantiable();
    }
}
