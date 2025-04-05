<?php

declare(strict_types = 1);

namespace Nayleen\Finder\Engine;

use Composer\Autoload\ClassLoader;
use Safe;
use Symfony\Component\Finder\Finder;

/**
 * @template-covariant T of object
 * @template-extends AbstractEngine<T>
 */
final class ComposerEngine extends AbstractEngine
{
    /**
     * @var ClassLoader[]
     */
    private readonly array $classLoaders;

    /**
     * @param ClassLoader[]|null $classLoaders
     */
    public function __construct(?array $classLoaders = null)
    {
        $classLoaders ??= ClassLoader::getRegisteredLoaders();
        assert(count($classLoaders) > 0);

        $this->classLoaders = $classLoaders;
    }

    /**
     * @return iterable<class-string<T>>
     */
    private function load(): iterable
    {
        $oldErrorHandler = set_error_handler(static fn () => true);

        try {
            foreach ($this->classLoaders as $classLoader) {
                foreach ($classLoader->getClassMap() as $class => $path) {
                    /**
                     * @var class-string<T> $class
                     */
                    yield $class;
                }

                if (
                    $classLoader->isClassMapAuthoritative()
                    || !class_exists(Finder::class)
                ) {
                    continue;
                }

                $prefixes = array_merge(
                    $classLoader->getPrefixesPsr4() ?? [],
                    $classLoader->getPrefixes() ?? [],
                );

                foreach ($prefixes as $namespace => $paths) {
                    $finder = Finder::create()
                        ->files()
                        ->in($paths)
                        ->ignoreDotFiles(true)
                        ->ignoreUnreadableDirs()
                        ->ignoreVCS(true)
                        ->ignoreVCSIgnored(true)
                        ->name('*.php');

                    foreach ($finder as $file) {
                        $relativePathName = $file->getRelativePathname();
                        $className = basename($relativePathName, '.php');
                        $class = sprintf(
                            '%s%s',
                            $namespace,
                            str_replace(
                                [DIRECTORY_SEPARATOR, '.php'],
                                ['\\', ''],
                                $relativePathName,
                            ),
                        );

                        $classNameInFileMatches = Safe\preg_match("#class\\s+{$className}\\s+#", $file->getContents());

                        if ($classNameInFileMatches !== 1) {
                            continue;
                        }

                        /**
                         * @var class-string<T> $class
                         */
                        yield $class;
                    }
                }
            }
        } finally {
            set_error_handler($oldErrorHandler);
        }
    }

    /**
     * @return iterable<class-string<T>>
     */
    protected function classes(): iterable
    {
        foreach ($this->load() as $class) {
            /** @var class-string<T> $class */
            yield $class;
        }
    }
}
