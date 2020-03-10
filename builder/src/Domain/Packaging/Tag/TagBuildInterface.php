<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Tag;

use Builder\Domain\Packaging;

interface TagBuildInterface extends TagInterface, Packaging\BuildableInterface
{
}