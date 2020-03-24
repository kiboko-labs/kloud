<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Tag;

interface DependentTagInterface extends TagInterface
{
    public function getParent(): TagInterface;
}
