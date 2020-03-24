<?php

declare(strict_types=1);

namespace Builder\Domain\Assert;

use Builder\Domain\Packaging;

final class BlackfireVersion implements ConstraintInterface
{
    private Packaging\RepositoryInterface $repository;
    private string $constraint;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        string $constraint
    ) {
        $this->repository = $repository;
        $this->constraint = $constraint;
    }

    public function apply(\Traversable $tagRepository): \Traversable
    {
        foreach ($tagRepository as $tag) {
            if (!preg_match('/-cli-blackfire(-|$)/', (string) $tag)) {
                continue;
            }

            yield new BlackfireVersionConstraint($this->repository, $tag, $this->constraint);
        }
    }
}
