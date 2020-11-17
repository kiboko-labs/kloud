<?php

declare(strict_types=1);

namespace Kiboko\Cloud\PHPSpec\Matcher\Iterate;

use Kiboko\Cloud\Domain\Packaging\Tag\DependentTagInterface;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Iterate as StandardIterate;

final class IterableTagsMatcher
{
    private Presenter $presenter;

    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * @param array|\Traversable $subject
     * @param array|\Traversable $expected
     *
     * @throws \InvalidArgumentException
     * @throws SubjectElementTagDoesNotMatchException
     * @throws SubjectElementParentTagDoesNotMatchException
     * @throws StandardIterate\SubjectHasMoreElementsException
     * @throws StandardIterate\SubjectHasFewerElementsException
     */
    public function match($subject, $expected): void
    {
        if (!$this->isIterable($subject)) {
            throw new \InvalidArgumentException('Subject value should be an array or implement \Traversable.');
        }

        if (!$this->isIterable($expected)) {
            throw new \InvalidArgumentException('Expected value should be an array or implement \Traversable.');
        }

        $expectedIterator = $this->createIteratorFromIterable($expected);

        $count = 0;
        foreach ($subject as $subjectKey => $subjectValue) {
            if (!$expectedIterator->valid()) {
                throw new StandardIterate\SubjectHasMoreElementsException();
            }

            if ($subjectKey !== $expectedIterator->key() || !$this->tagIsEqual($subjectValue, $expectedIterator->current())) {
                throw new SubjectElementTagDoesNotMatchException($count, $this->presenter->presentValue($subjectKey), $this->presenter->presentValue((string) $subjectValue), $this->presenter->presentValue($expectedIterator->key()), $this->presenter->presentValue((string) $expectedIterator->current()));
            }

            if ($subjectKey !== $expectedIterator->key() || !$this->parentIsEqual($subjectValue, $expectedIterator->current())) {
                throw new SubjectElementParentTagDoesNotMatchException($count, $this->presenter->presentValue($subjectKey), $this->presenter->presentValue((string) $subjectValue->getParent()), $this->presenter->presentValue($expectedIterator->key()), $this->presenter->presentValue((string) $expectedIterator->current()->getParent()));
            }

            $expectedIterator->next();
            ++$count;
        }

        if ($expectedIterator->valid()) {
            throw new StandardIterate\SubjectHasFewerElementsException();
        }
    }

    /**
     * @param mixed $variable
     */
    private function isIterable($variable): bool
    {
        return \is_array($variable) || $variable instanceof \Traversable;
    }

    /**
     * @param array|\Traversable $iterable
     */
    private function createIteratorFromIterable($iterable): \Iterator
    {
        if (\is_array($iterable)) {
            return new \ArrayIterator($iterable);
        }

        $iterator = new \IteratorIterator($iterable);
        $iterator->rewind();

        return $iterator;
    }

    private function parentIsEqual($expected, $value): bool
    {
        if (!$expected instanceof DependentTagInterface) {
            if ($value instanceof DependentTagInterface) {
                throw new \InvalidArgumentException('Subject item should not implement DependentTagInterface.');
            }

            return true;
        }

        if (!$value instanceof DependentTagInterface) {
            throw new \InvalidArgumentException('Subject item should implement DependentTagInterface.');
        }

        return (string) $expected->getParent() === (string) $value->getParent();
    }

    private function tagIsEqual($expected, $value): bool
    {
        if (!$expected instanceof DependentTagInterface) {
            if ($value instanceof DependentTagInterface) {
                throw new \InvalidArgumentException('Subject item should not implement DependentTagInterface.');
            }

            return (string) $expected === (string) $value;
        }

        if (!$value instanceof DependentTagInterface) {
            throw new \InvalidArgumentException('Subject item should implement DependentTagInterface.');
        }

        return (string) $expected === (string) $value;
    }
}
