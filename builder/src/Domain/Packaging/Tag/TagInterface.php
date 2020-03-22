<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Tag;

use Builder\Domain\Packaging;

interface TagInterface extends \Stringable
{
    public function getContext(): Packaging\Context\ContextInterface;
    public function getRepository(): Packaging\RepositoryInterface;
}
