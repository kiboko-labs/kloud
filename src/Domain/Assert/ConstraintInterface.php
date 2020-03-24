<?php

declare(strict_types=1);

namespace Builder\Domain\Assert;

interface ConstraintInterface
{
    public function apply(\Traversable $tagRepository): \Traversable;
}
