<?php declare(strict_types=1);

namespace Builder;

interface DependentTagInterface extends TagInterface
{
    public function getParent(): TagInterface;
}