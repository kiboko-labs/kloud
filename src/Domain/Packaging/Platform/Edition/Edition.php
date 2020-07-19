<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

class Edition implements EditionInterface
{
    private string $package;
    private string $version;
    private string $edition;
    private string $phpConstraint;
    private string $phpExperimentalConstraint;

    public function __construct(string $package, string $version, string $edition, string $phpConstraint = '*', ?string $phpExperimentalConstraint = null)
    {
        $this->package = $package;
        $this->version = $version;
        $this->edition = $edition;
        $this->phpConstraint = $phpConstraint;
        $this->phpExperimentalConstraint = $phpExperimentalConstraint ?? $phpConstraint;
    }

    public function getPackage(): string
    {
        return $this->package;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getEdition(): string
    {
        return $this->edition;
    }

    public function getPhpConstraint(): string
    {
        return $this->phpConstraint;
    }

    public function getPhpExperimentalConstraint(): string
    {
        return $this->phpExperimentalConstraint;
    }
}