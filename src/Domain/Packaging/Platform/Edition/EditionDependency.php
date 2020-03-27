<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

class EditionDependency extends Edition implements EditionDependencyInterface
{
    private Edition $parent;

    public function __construct(string $package, string $version, string $edition, Edition $parent)
    {
        parent::__construct($package, $version, $edition, $parent->getPhpConstraint());
        $this->parent = $parent;
    }

    public function getParentPackage(): string
    {
        return $this->parent->getPackage();
    }

    public function getParentVersion(): string
    {
        return $this->parent->getVersion();
    }

    public function getParentEdition(): string
    {
        return $this->parent->getEdition();
    }
}