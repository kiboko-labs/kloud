<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Config;

use Kiboko\Cloud\Domain\Packaging;

final class Config
{
    private Packaging\RepositoryInterface $dbgpRepository;
    private Packaging\RepositoryInterface $postgresqlRepository;
    private Packaging\RepositoryInterface $phpRepository;
    private bool $withExperimental;

    public function __construct(
        Packaging\RepositoryInterface $dbgpRepository,
        Packaging\RepositoryInterface $postgresqlRepository,
        Packaging\RepositoryInterface $phpRepository,
        bool $withExperimental = false
    ) {
        $this->dbgpRepository = $dbgpRepository;
        $this->postgresqlRepository = $postgresqlRepository;
        $this->phpRepository = $phpRepository;
        $this->withExperimental = $withExperimental;
    }

    /** @return Packaging\PackageInterface[] */
    public static function builds(
        string $configPath,
        Packaging\RepositoryInterface $dbgpRepository,
        Packaging\RepositoryInterface $postgresqlRepository,
        Packaging\RepositoryInterface $phpRepository,
        bool $withExperimental = false
    ): iterable {
        $config = new self($dbgpRepository, $postgresqlRepository, $phpRepository, $withExperimental);

        return $config->walkBuilds(require $configPath.'/builds.php');
    }

    /** @return Packaging\PackageInterface[]  */
    public function walkBuilds(callable $callback): iterable
    {
        return new \ArrayIterator(
            iterator_to_array($callback(
                $this->dbgpRepository,
                $this->postgresqlRepository,
                $this->phpRepository,
                $this->withExperimental
            )),
            \CachingIterator::FULL_CACHE
        );
    }
}
