<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

class Edition implements EditionInterface
{
    private string $package;
    private string $version;
    private string $edition;
    private string $phpConstraint;

    public function __construct(string $package, string $version, string $edition, string $phpConstraint = '*')
    {
        $this->package = $package;
        $this->version = $version;
        $this->edition = $edition;
        $this->phpConstraint = $phpConstraint;
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
}