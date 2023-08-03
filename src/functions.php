<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use Nayleen\Finder\Engine\BetterReflectionEngine;

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

    $defaultEngine ??= BetterReflectionEngine::class;
    assert(is_a($defaultEngine, Engine::class, true));

    return new ($defaultEngine)();
}
