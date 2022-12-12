<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Generator;
use Roave\BetterReflection\Identifier\IdentifierType;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\SourceLocator;

final class BetterReflectionEngine extends AbstractEngine
{
    public function __construct(private readonly SourceLocator $sourceLocator)
    {
    }

    /**
     * @return Generator<class-string>
     */
    protected function classes(): iterable
    {
        $reflector = new DefaultReflector($this->sourceLocator);
        $identifierType = new IdentifierType(IdentifierType::IDENTIFIER_CLASS);

        foreach ($this->sourceLocator->locateIdentifiersByType($reflector, $identifierType) as $classReflection) {
            assert($classReflection instanceof ReflectionClass);

            /** @var class-string $class */
            $class = (string) $classReflection;
            yield $class;
        }
    }
}
