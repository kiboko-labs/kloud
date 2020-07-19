<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Config;

use Kiboko\Cloud\Domain\Packaging;

final class Config
{
    private bool $withExperimental;

    public function __construct(bool $withExperimental)
    {
        $this->withExperimental = $withExperimental;
    }

    /** @return Packaging\PackageInterface[]  */
    public static function builds(string $configPath, bool $withExperimental = false): iterable
    {
        $config = new self($withExperimental);

        return $config->walkBuilds(require $configPath.'/builds.php');
    }

    /** @return Packaging\PackageInterface[]  */
    public function walkBuilds(callable $callback): iterable
    {
        return new \ArrayIterator(
//            new \NoRewindIterator(
                iterator_to_array($callback($this->withExperimental)),
//            ),
            \CachingIterator::FULL_CACHE
        );
    }
}