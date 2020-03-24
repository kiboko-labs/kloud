<?php declare(strict_types=1);

namespace Builder\Domain\Packaging;

interface ContextRepositoryInterface
{
    public function __invoke(): \Traversable;
}
