<?php declare(strict_types=1);

namespace Builder\PHPSpec\Matcher\Iterate;

use Builder\DependentTagInterface;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Iterate;

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
     * @throws Iterate\SubjectElementDoesNotMatchException
     * @throws Iterate\SubjectHasFewerElementsException
     * @throws Iterate\SubjectHasMoreElementsException
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
                throw new Iterate\SubjectHasMoreElementsException();
            }

            if ($subjectKey !== $expectedIterator->key() || !$this->valueIsEqual($subjectValue, $expectedIterator->current())) {
                throw new Iterate\SubjectElementDoesNotMatchException(
                    $count,
                    $this->presenter->presentValue($subjectKey),
                    $this->presenter->presentValue($subjectValue),
                    $this->presenter->presentValue($expectedIterator->key()),
                    $this->presenter->presentValue($expectedIterator->current())
                );
            }

            $expectedIterator->next();
            ++$count;
        }

        if ($expectedIterator->valid()) {
            throw new Iterate\SubjectHasFewerElementsException();
        }
    }

    /**
     * @param mixed $variable
     *
     * @return bool
     */
    private function isIterable($variable): bool
    {
        return \is_array($variable) || $variable instanceof \Traversable;
    }

    /**
     * @param array|\Traversable $iterable
     *
     * @return \Iterator
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

    private function valueIsEqual($expected, $value): bool
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

        return (string) $expected === (string) $value
            && (string) $expected->getParent() === (string) $value->getParent();
    }
}
