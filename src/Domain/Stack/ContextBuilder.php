<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack\DTO\Context;

final class ContextBuilder
{
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

    public function __construct(RepositoryInterface $repository, string $phpVersion)
    {
        $this->repository = $repository;
        $this->phpVersion = $phpVersion;
        $this->selfManagedServices = [];
        $this->selfManagedVolumes = [];
        $this->dbms = null;
        $this->application = null;
        $this->applicationVersion = null;
        $this->isEnterpriseEdition = null;
        $this->withBlackfire = null;
        $this->withXdebug = null;
        $this->withDejavu = null;
        $this->withElasticStack = null;
        $this->withDockerForMacOptimizations = null;
    }

    public function getContext(): Context
    {
        $context = new Context($this->repository, $this->phpVersion, $this->application, $this->applicationVersion, $this->dbms, $this->isEnterpriseEdition);
        $context->withBlackfire = $this->withBlackfire;
        $context->withXdebug = $this->withXdebug;
        $context->withDejavu = $this->withDejavu;
        $context->withElasticStack = $this->withElasticStack;
        $context->withDockerForMacOptimizations = $this->withDockerForMacOptimizations;

        return $context;
    }

    public function withBlackfire(?bool $withBlackfire): self
    {
        $this->withBlackfire = $withBlackfire;

        return $this;
    }

    public function withXdebug(?bool $withXdebug): self
    {
        $this->withXdebug = $withXdebug;

        return $this;
    }

    public function withDejavu(?bool $withDejavu): self
    {
        $this->withDejavu = $withDejavu;

        return $this;
    }

    public function withElasticStack(?bool $withElasticStack): self
    {
        $this->withElasticStack = $withElasticStack;

        return $this;
    }

    public function setDbms(?string $dbms): self
    {
        $this->dbms = $dbms;

        return $this;
    }

    public function setApplication(?string $application, ?string $applicationVersion, ?bool $isEnterpriseEdition): self
    {
        $this->application = $application;
        $this->applicationVersion = $applicationVersion;
        $this->isEnterpriseEdition = $isEnterpriseEdition;

        return $this;
    }

    public function withDockerForMacOptimizations(?bool $withDockerForMacOptimizations): self
    {
        $this->withDockerForMacOptimizations = $withDockerForMacOptimizations;

        return $this;
    }

    public function addSelfManagedService(string ...$serviceNames): self
    {
        array_push($this->selfManagedServices, $serviceNames);

        return $this;
    }

    public function addSelfManagedVolumes(string ...$volumeNames): self
    {
        array_push($this->selfManagedVolumes, $volumeNames);

        return $this;
    }
}
