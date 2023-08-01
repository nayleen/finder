<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Generator;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Identifier\IdentifierType;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\SourceLocator;

/**
 * @template-covariant T of object
 * @template-extends AbstractEngine<T>
 */
final class BetterReflectionEngine extends AbstractEngine
{
    private readonly SourceLocator $sourceLocator;

    public function __construct(?SourceLocator $sourceLocator = null)
    {
        $this->sourceLocator = $sourceLocator ?? (new BetterReflection())->sourceLocator();
    }

    /**
     * @return Generator<class-string<T>>
     */
    protected function classes(): iterable
    {
        $reflector = new DefaultReflector($this->sourceLocator);
        $identifierType = new IdentifierType(IdentifierType::IDENTIFIER_CLASS);

        foreach ($this->sourceLocator->locateIdentifiersByType($reflector, $identifierType) as $classReflection) {
            assert($classReflection instanceof ReflectionClass);

            /**
             * @var class-string<T> $class
             */
            $class = (string) $classReflection;
            yield $class;
        }
    }
}
