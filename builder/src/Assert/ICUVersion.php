<?php declare(strict_types=1);

namespace Builder\Assert;

use Builder\Package\RepositoryInterface;

final class ICUVersion implements ConstraintInterface
{
    private RepositoryInterface $repository;
    private string $constraint;
    private string $regex;

    public function __construct(RepositoryInterface $repository, string $constraint, string $regex)
    {
        $this->repository = $repository;
        $this->constraint = $constraint;
        $this->regex = $regex;
    }

    public function apply(\Traversable $tagRepository): \Traversable
    {
        foreach ($tagRepository as $tag) {
            if (!preg_match($this->regex, (string)$tag)) {
                continue;
            }

            yield new ICUVersionConstraint($this->repository, $tag, $this->constraint);
        }
    }
}