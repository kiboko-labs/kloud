<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert\Result;

use Kiboko\Cloud\Domain\Packaging;

final class ICUMissingOrBroken implements AssertionFailureInterface
{
    private Packaging\Tag\TagInterface $tag;

    public function __construct(Packaging\Tag\TagInterface $tag)
    {
        $this->tag = $tag;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return 'The PHP extension intl or ICU library is missing or broken.';
    }
}
