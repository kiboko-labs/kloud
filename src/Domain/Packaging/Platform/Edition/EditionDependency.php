<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

class EditionDependency extends Edition
{
    public Edition $parent;

    public function __construct(string $package, string $version, string $edition, Edition $parent)
    {
        parent::__construct($package, $version, $edition);
        $this->parent = $parent;
    }
}