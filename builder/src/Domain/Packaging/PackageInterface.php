<?php declare(strict_types=1);

namespace Builder\Domain\Packaging;

use Builder\Domain\Packaging;

interface PackageInterface extends \Traversable, Packaging\ContextRepositoryInterface
{
}
