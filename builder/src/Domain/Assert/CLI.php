<?php

declare(strict_types=1);

namespace Builder\Domain\Assert;

use Builder\Domain\Packaging;

final class CLI implements ConstraintInterface
{
    private Packaging\RepositoryInterface $repository;
    private string $constraint;

    public function __construct(
        Packaging\RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function apply(\Traversable $tagRepository): \Traversable
    {
        foreach ($tagRepository as $tag) {
            if (!preg_match('/-cli(-|$)/', (string) $tag)) {
                continue;
            }

            yield new CLIConstraint($this->repository, $tag);
        }
    }
}
