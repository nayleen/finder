<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

final class ImplementsInterface implements Expectation
{
    /**
     * @param class-string $interface
     * @psalm-param interface-string $interface
     */
    public function __construct(private readonly string $interface)
    {
    }

    public function __invoke(string $class): bool
    {
        $implementedInterfaces = class_implements($class);

        if (!$implementedInterfaces) {
            return false;
        }

        /* @var class-string[] $implementedInterfaces */
        /* @psalm-var interface-string[] $implementedInterfaces */
        return in_array($this->interface, $implementedInterfaces, true);
    }
}
