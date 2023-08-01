<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class CallableExpectation extends AbstractExpectation
{
    /**
     * @var callable(class-string): bool
     */
    private $callable;

    /**
     * @param callable(class-string): bool $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function __invoke(string $class): bool
    {
        return ($this->callable)($class);
    }
}
