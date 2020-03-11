<?php

declare(strict_types=1);

namespace Builder\Domain\Assert\Result;

use Builder\Domain\Packaging\Tag\TagInterface;

interface AssertionResultInterface
{
    public function is(TagInterface $tag): bool;
    public function __toString();
}
