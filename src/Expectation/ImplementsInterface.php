<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Finder\Expectation;
use Safe;
use Throwable;

final class ImplementsInterface implements Expectation
{
    /**
     * @param class-string $interface
     */
    public function __construct(private readonly string $interface)
    {
        assert(interface_exists($this->interface));
    }

    public function __invoke(string $class): bool
    {
        try {
            $implementedInterfaces = Safe\class_implements($class);

            /* @var class-string[] $implementedInterfaces */
            return in_array($this->interface, $implementedInterfaces, true);
        } catch (Throwable) {
            return false;
        }
    }
}
