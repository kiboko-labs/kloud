<?php declare(strict_types=1);

namespace Builder\Assert\Result;

use Builder\TagInterface;

final class PHPExtensionVersionInvalid implements AssertionFailureInterface
{
    private TagInterface $tag;
    private string $extension;
    private string $version;
    private string $constraint;

    public function __construct(TagInterface $tag, string $extension, string $version, string $constraint)
    {
        $this->tag = $tag;
        $this->extension = $extension;
        $this->version = $version;
        $this->constraint = $constraint;
    }

    public function __toString()
    {
        return sprintf('%s: Version for PHP extension %s does not match constraint "%s", found %s.', $this->tag, $this->extension, $this->constraint, $this->version);
    }
}