<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native\PostgreSQL;

use Kiboko\Cloud\Domain\Packaging;

final class Tag implements Packaging\Tag\TagBuildInterface
{
    use Packaging\Tag\TagTrait;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Context\BuildableContextInterface $context
    ) {
        $this->repository = $repository;
        $this->name = new Packaging\Placeholder('%postgresql.version%', $context->getArrayCopy());
        $this->context = $context;
    }
}