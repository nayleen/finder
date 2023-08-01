<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use Nayleen\Finder\Engine\BetterReflectionEngine;
use Nayleen\Finder\Engine\ComposerEngine;
use Roave\BetterReflection\BetterReflection;

/**
 * @param class-string<Engine>|null $engine
 */
function defaultEngine(?string $engine = null): Engine
{
    static $defaultEngine = null;

    if (isset($engine)) {
        assert(is_a($engine, Engine::class, true));
        $defaultEngine = $engine;
    }

    // @codeCoverageIgnoreStart
    $defaultEngine ??= class_exists(BetterReflection::class)
        ? BetterReflectionEngine::class
        : ComposerEngine::class;
    // @codeCoverageIgnoreEnd

    assert(is_a($defaultEngine, Engine::class, true));

    return new ($defaultEngine)();
}
