<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert\Result;

use Kiboko\Cloud\Domain\Packaging\Tag\TagInterface;

interface AssertionResultInterface extends \Stringable
{
    public function is(TagInterface $tag): bool;
}
