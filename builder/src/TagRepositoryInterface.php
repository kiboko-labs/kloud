<?php declare(strict_types=1);

namespace Builder;

interface TagRepositoryInterface extends \Traversable
{
    public function __invoke(): \Traversable;
}