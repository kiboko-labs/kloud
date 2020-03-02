<?php declare(strict_types=1);

namespace Builder\Assert;

use Builder\Package\RepositoryInterface;

final class PHPExtensionVersion implements ConstraintInterface
{
    private RepositoryInterface $repository;
    private string $extension;
    private string $constraint;
    private string $regex;

    public function __construct(RepositoryInterface $repository, string $extension, string $constraint, string $regex)
    {
        $this->repository = $repository;
        $this->extension = $extension;
        $this->constraint = $constraint;
        $this->regex = $regex;
    }

    public function apply(\Traversable $tagRepository): \Traversable
    {
        foreach ($tagRepository as $tag) {
            if (!preg_match($this->regex, (string)$tag)) {
                continue;
            }

            yield new PHPExtensionVersionConstraint($this->repository, $tag, $this->extension, $this->constraint);
        }
    }
}