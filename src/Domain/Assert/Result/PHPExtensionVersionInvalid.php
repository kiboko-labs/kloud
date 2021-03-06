<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert\Result;

use Kiboko\Cloud\Domain\Packaging;

final class PHPExtensionVersionInvalid implements AssertionFailureInterface
{
    private Packaging\Tag\TagInterface $tag;
    private string $extension;
    private string $version;
    private string $constraint;

    public function __construct(Packaging\Tag\TagInterface $tag, string $extension, string $version, string $constraint)
    {
        $this->tag = $tag;
        $this->extension = $extension;
        $this->version = $version;
        $this->constraint = $constraint;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return sprintf('Version for PHP extension %s does not match constraint "%s", found %s.', $this->extension, $this->constraint, $this->version);
    }
}
