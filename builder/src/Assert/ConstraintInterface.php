<?php declare(strict_types=1);

namespace Builder\Assert;

interface ConstraintInterface
{
    public function apply(\Traversable $tagRepository): \Traversable;
}