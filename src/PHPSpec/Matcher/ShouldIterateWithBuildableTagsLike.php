<?php

declare(strict_types=1);

namespace Kiboko\Cloud\PHPSpec\Matcher;

use Kiboko\Cloud\PHPSpec\Matcher\Iterate\IterableBuildableTagsMatcher;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Iterate;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Wrapper\DelayedCall;

final class ShouldIterateWithBuildableTagsLike implements Matcher
{
    private IterableBuildableTagsMatcher $iterablesMatcher;

    public function __construct(Presenter $presenter)
    {
        $this->iterablesMatcher = new IterableBuildableTagsMatcher($presenter);
    }

    public function supports(string $name, $subject, array $arguments): bool
    {
        return \in_array($name, ['iterateBuildableTagsLike', 'yieldBuildableTagsLike'])
            && 1 === \count($arguments)
            && ($subject instanceof \Traversable || \is_array($subject))
            && ($arguments[0] instanceof \Traversable || \is_array($arguments[0]))
        ;
    }

    public function positiveMatch(string $name, $subject, array $arguments): ?DelayedCall
    {
        try {
            $this->iterablesMatcher->match($subject, $arguments[0]);
        } catch (Iterate\SubjectHasFewerElementsException $exception) {
            throw new FailureException('Expected subject to have the same number of elements than matched value, but it has fewer.', 0, $exception);
        } catch (Iterate\SubjectHasMoreElementsException $exception) {
            throw new FailureException('Expected subject to have the same number of elements than matched value, but it has more.', 0, $exception);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function negativeMatch(string $name, $subject, array $arguments): ?DelayedCall
    {
        try {
            $this->positiveMatch($name, $subject, $arguments);
        } catch (FailureException $exception) {
            return null;
        }

        throw new FailureException('Expected subject not to iterate the same as matched value, but it does.');
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 100;
    }
}
