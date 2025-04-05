<?php

declare(strict_types = 1);

namespace Nayleen\Finder {
    use Nayleen\Finder\Engine\ComposerEngine;

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

        $defaultEngine ??= ComposerEngine::class;
        assert(is_a($defaultEngine, Engine::class, true));

        return new ($defaultEngine)();
    }
}

namespace Nayleen\Finder\Expectation {
    use Nayleen\Finder\Expectation;
    use Nayleen\Finder\Expectation\Combinator\Composed;

    function compose(Expectation $a, Expectation $b): Composed
    {
        return new Composed($a, $b);
    }
}
