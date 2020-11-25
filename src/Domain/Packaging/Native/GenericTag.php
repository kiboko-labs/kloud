<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native;

use Kiboko\Cloud\Domain\Packaging;

final class GenericTag implements Packaging\Tag\TagBuildInterface
{
    use Packaging\Tag\TagTrait;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Context\BuildableContextInterface $context,
        string $name = 'latest'
    ) {
        $this->repository = $repository;
        $this->name = new Packaging\Placeholder($name, $context->getArrayCopy());
        $this->context = $context;
    }
}