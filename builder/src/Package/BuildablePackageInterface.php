<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\BuildableInterface;

interface BuildablePackageInterface extends BuildableInterface
{
    public function buildPath(array $variables);
}