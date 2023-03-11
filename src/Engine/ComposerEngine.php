<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Composer\Autoload\ClassLoader;

/**
 * @template T of object
 * @template-extends AbstractEngine<T>
 */
final class ComposerEngine extends AbstractEngine
{
    /**
     * @param ClassLoader[] $classLoaders
     */
    public function __construct(private readonly array $classLoaders)
    {
    }

    public static function create(): self
    {
        return new self(ClassLoader::getRegisteredLoaders());
    }

    /**
     * @return iterable<class-string<T>>
     */
    protected function classes(): iterable
    {
        foreach ($this->classLoaders as $classLoader) {
            /** @var class-string[] $classes */
            $classes = array_keys($classLoader->getClassMap());

            foreach ($classes as $class) {
                /** @var class-string<T> $class */
                yield $class;
            }
        }
    }
}
