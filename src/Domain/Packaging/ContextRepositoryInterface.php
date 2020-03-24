<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging;

interface ContextRepositoryInterface
{
    public function __invoke(): \Traversable;
}
