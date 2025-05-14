<?php

declare(strict_types = 1);

namespace Nayleen\Finder;

use Safe;

final class Dumper
{
    /**
     * @var non-empty-string
     */
    private const ENV_KEY = 'NAYLEEN_FINDER_DUMP_PATH';

    public function __construct(private readonly Engine $engine) {}

    public static function file(): string
    {
        return self::path() . '/nayleen-finder-dump.json';
    }

    private static function path(): string
    {
        $path = $_SERVER[self::ENV_KEY] ?? $_ENV[self::ENV_KEY] ?? sys_get_temp_dir();

        if (!is_dir($path)) {
            Safe\mkdir($path, 0777, true);
        }

        return $path;
    }

    public function dump(): void
    {
        $list = [];

        foreach ($this->engine->find(new Expectation\Any()) as $class) {
            $list[] = $class;
        }

        Safe\file_put_contents(
            self::file(),
            Safe\json_encode($list),
        );
    }
}
