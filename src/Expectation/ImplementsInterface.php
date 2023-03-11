<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Safe\Exceptions\SplException;

use function Safe\class_implements;

final class ImplementsInterface implements Expectation
{
    /**
     * @param class-string $interface
     */
    public function __construct(private readonly string $interface)
    {
    }

    public function __invoke(string $class): bool
    {
        try {
            $implementedInterfaces = class_implements($class);

            /* @var class-string[] $implementedInterfaces */
            return in_array($this->interface, $implementedInterfaces, true);
        } catch (SplException) {
            return false;
        }
    }
}
