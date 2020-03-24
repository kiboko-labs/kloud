<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert;

interface ConstraintInterface
{
    public function apply(\Traversable $tagRepository): \Traversable;
}
