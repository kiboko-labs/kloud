<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert;

use Kiboko\Cloud\Domain\Packaging;

final class NodeJS implements ConstraintInterface
{
    private Packaging\RepositoryInterface $repository;
    private string $constraint;
    private string $regex;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        string $constraint,
        string $regex
    ) {
        $this->repository = $repository;
        $this->constraint = $constraint;
        $this->regex = $regex;
    }

    public function apply(\Traversable $tagRepository): \Traversable
    {
        foreach ($tagRepository as $tag) {
            if (!preg_match($this->regex, (string) $tag)) {
                continue;
            }

            yield new NodeJSConstraint($this->repository, $tag, $this->constraint);
        }
    }
}
