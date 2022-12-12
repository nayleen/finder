<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Expectation;

use ReflectionClass;

abstract class ReflectionExpectation extends AbstractExpectation
{
    /**
     * @var array<class-string, ReflectionClass>
     */
    private static array $cache = [];

    final public function __destruct()
    {
        self::$cache = [];
    }

    /**
     * @param class-string $class
     */
    final protected function reflect(string $class): ReflectionClass
    {
        return self::$cache[$class] ?? (self::$cache[$class] = new ReflectionClass($class));
    }
}
