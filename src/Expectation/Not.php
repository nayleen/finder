<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class Not extends AbstractExpectation
{
    public function __construct(private readonly Expectation $other)
    {
    }

    public function __invoke(string $class): bool
    {
        return !($this->other)($class);
    }
}
