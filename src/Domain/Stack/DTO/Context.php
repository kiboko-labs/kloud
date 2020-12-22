<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\DTO;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;

final class Context
{
    const DBMS_POSTGRESQL = 'postgresql';
    const DBMS_MYSQL = 'mysql';

    public RepositoryInterface $repository;
    public string $phpVersion;
    public ?string $dbms;
    public ?string $application;
    public ?string $applicationVersion;
    public ?bool $isEnterpriseEdition;
    public ?bool $withBlackfire;
    public ?bool $withXdebug;
    public ?bool $withDejavu;
    public ?bool $withElasticStack;
    public ?bool $withDockerForMacOptimizations;
    public array $selfManagedServices;
    public array $selfManagedVolumes;

    public function __construct(
        RepositoryInterface $repository,
        string $phpVersion,
        ?string $application = null,
        ?string $applicationVersion = null,
        ?string $dbms = null,
        ?bool $isEnterpriseEdition = false
    ) {
        $this->repository = $repository;
        $this->phpVersion = $phpVersion;
        $this->dbms = $dbms;
        $this->application = $application;
        $this->applicationVersion = $applicationVersion;
        $this->isEnterpriseEdition = $isEnterpriseEdition;
        $this->withBlackfire = null;
        $this->withXdebug = null;
        $this->withDejavu = null;
        $this->withElasticStack = null;
        $this->withDockerForMacOptimizations = null;
        $this->selfManagedServices = [];
        $this->selfManagedVolumes = [];
    }

    public function getPHPImagesRegex(): string
    {
        if ($this->withBlackfire && $this->withXdebug) {
            $variations = '(?:|-blackfire|-xdebug)';
        } elseif ($this->withBlackfire && !$this->withXdebug) {
            $variations = '(?:|-blackfire)';
        } elseif (!$this->withBlackfire && $this->withXdebug) {
            $variations = '(?:|-xdebug)';
        } else {
            $variations = '';
        }

        if (empty($this->application) || empty($this->applicationVersion)) {
            if (empty($this->dbms)) {
                return sprintf(
                    '/^%s:%s-(?:cli|fpm)%s$/',
                    preg_quote((string) $this->repository, '/'),
                    preg_quote($this->phpVersion, '/'),
                    $variations
                );
            }

            return sprintf(
                '/^%s:%s-(?:cli|fpm)%s-%s$/',
                preg_quote((string) $this->repository, '/'),
                preg_quote($this->phpVersion, '/'),
                $variations,
                $this->dbms
            );
        }

        return sprintf(
            '/^%s:%s-(?:cli|fpm)%s-%s-%s-%s-%s$/',
            preg_quote((string) $this->repository, '/'),
            preg_quote($this->phpVersion, '/'),
            $variations,
            $this->application,
            $this->isEnterpriseEdition ? 'ee' : 'ce',
            preg_quote($this->applicationVersion, '/'),
            $this->dbms
        );
    }
}
