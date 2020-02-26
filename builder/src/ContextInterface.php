<?php declare(strict_types=1);

namespace Builder;

interface ContextInterface extends \ArrayAccess, \Countable, \Traversable
{
    public function getArrayCopy();
}