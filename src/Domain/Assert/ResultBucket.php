<?php declare(strict_types=1);

namespace Builder\Domain\Assert;

use Builder\Domain\Assert;
use Builder\Domain\Packaging\Tag\TagInterface;
use Exception;
use Traversable;

final class ResultBucket
{
    /** @var array<array-key, AssertionFailureInterface> */
    private array $failures;
    /** @var array<array-key, AssertionSuccessInterface> */
    private array $successes;

    public function __construct()
    {
        $this->failures = [];
        $this->successes = [];
    }

    public function failure(Assert\Result\AssertionFailureInterface ...$result): void
    {
        array_push($this->failures, ...$result);
    }

    public function success(Assert\Result\AssertionSuccessInterface ...$result): void
    {
        array_push($this->successes, ...$result);
    }

    public function getSuccessesFor(TagInterface $tag): array
    {
        return array_filter($this->successes, function (Assert\Result\AssertionSuccessInterface $success) use ($tag) {
            return $success->is($tag);
        });
    }

    public function getFailuresFor(TagInterface $tag): array
    {
        return array_filter($this->failures, function (Assert\Result\AssertionFailureInterface $failure) use ($tag) {
            return $failure->is($tag);
        });
    }
}