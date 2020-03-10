<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Tag;

use Builder\Domain\Packaging;

interface TagInterface
{
    public function getContext(): Packaging\Context\ContextInterface;
    public function getRepository(): Packaging\RepositoryInterface;
    public function __toString();
}
