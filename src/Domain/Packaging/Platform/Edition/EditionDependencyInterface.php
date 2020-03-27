<?php

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

interface EditionDependencyInterface extends EditionInterface
{
    public function getParentPackage(): string;
    public function getParentVersion(): string;
    public function getParentEdition(): string;
}