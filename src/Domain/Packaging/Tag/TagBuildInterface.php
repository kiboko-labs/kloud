<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Tag;

use Kiboko\Cloud\Domain\Packaging;

interface TagBuildInterface extends TagInterface, Packaging\BuildableInterface
{
}