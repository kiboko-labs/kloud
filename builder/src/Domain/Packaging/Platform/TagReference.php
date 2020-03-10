<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform;

use Builder\Domain\Packaging;

final class TagReference implements Packaging\Tag\TagReferenceInterface
{
    private Packaging\RepositoryInterface $repository;
    private Packaging\Placeholder $name;
    private Packaging\Context\ContextInterface $context;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Context\ContextInterface $context
    ) {
        $this->repository = $repository;
        $this->name = new Packaging\Placeholder('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $context->getArrayCopy());
        $this->context = $context;
    }

    public function getContext(): Packaging\Context\ContextInterface
    {
        return $this->context;
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getRepository(): Packaging\RepositoryInterface
    {
        return $this->repository;
    }
}