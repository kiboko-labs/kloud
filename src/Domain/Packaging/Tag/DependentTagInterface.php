<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Tag;

interface DependentTagInterface extends TagInterface
{
    public function getParent(): TagInterface;
}
