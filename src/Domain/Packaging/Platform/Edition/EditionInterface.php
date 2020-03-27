<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

interface EditionInterface
{
    public function getPackage(): string;
    public function getVersion(): string;
    public function getEdition(): string;
    public function getPhpConstraint(): string;
}