<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging;

use Kiboko\Cloud\Domain\Packaging;

interface PackageInterface extends \Traversable, Packaging\ContextRepositoryInterface
{
}
