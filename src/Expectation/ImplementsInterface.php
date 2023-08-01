<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use Nayleen\Finder\Expectation;

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
        /** @phpstan-ignore-next-line */
        $implementedInterfaces = class_implements($class);

        if ($implementedInterfaces === false) {
            return false;
        }

        /* @var class-string[] $implementedInterfaces */
        return in_array($this->interface, $implementedInterfaces, true);
    }
}
