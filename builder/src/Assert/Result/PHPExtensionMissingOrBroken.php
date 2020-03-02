<?php declare(strict_types=1);

namespace Builder\Assert\Result;

use Builder\TagInterface;

final class PHPExtensionMissingOrBroken implements AssertionFailureInterface
{
    private TagInterface $tag;
    private string $extension;

    public function __construct(TagInterface $tag, string $extension)
    {
        $this->tag = $tag;
        $this->extension = $extension;
    }

    public function __toString()
    {
        return sprintf('%s: The PHP extension %s is missing or broken.', $this->tag, $this->extension);
    }
}