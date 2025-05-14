<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Nayleen\Finder\Dumper;
use Nayleen\Finder\Engine;
use Safe;

/**
 * @template-covariant T of object
 * @template-extends AbstractEngine<T>
 */
final class CachedEngine extends AbstractEngine
{
    private readonly AbstractEngine $cache; // @phpstan-ignore-line

    /**
     * @var non-empty-string
     */
    private const ENV_KEY = 'NAYLEEN_FINDER_IGNORE_DUMP';

    /**
     * @param Engine<T> $fallback
     */
    public function __construct(private readonly Engine $fallback = new ComposerEngine()) {}

    private static function ignoreDump(): bool
    {
        return filter_var(
            $_SERVER[self::ENV_KEY] ?? $_ENV[self::ENV_KEY] ?? false,
            FILTER_VALIDATE_BOOL,
        );
    }

    /**
     * @return iterable<class-string<T>>
     */
    protected function classes(): iterable
    {
        if (isset($this->cache)) {
            foreach ($this->cache->classes() as $class) {
                /** @var class-string<T> $class */
                yield $class;
            }
        }

        $file = Dumper::file();

        if (!self::ignoreDump() && file_exists($file)) {
            $classes = Safe\json_decode(Safe\file_get_contents($file), true);
            assert(is_array($classes));

            $this->cache = new ArrayEngine($classes); // @phpstan-ignore-line
        } else {
            $this->cache = new MemoizedEngine($this->fallback); // @phpstan-ignore-line
        }

        return $this->classes();
    }
}
