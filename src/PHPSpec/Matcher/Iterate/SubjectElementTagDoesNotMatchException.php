<?php

declare(strict_types=1);

namespace Kiboko\Cloud\PHPSpec\Matcher\Iterate;

use PhpSpec\Exception\Example\FailureException;

class SubjectElementTagDoesNotMatchException extends FailureException
{
    public function __construct(int $elementNumber, string $subjectKey, string $subjectValue, string $expectedKey, string $expectedValue)
    {
        parent::__construct(sprintf(
            'Expected subject to have element #%d with key %s and tag %s, but got key %s and tag %s.',
            $elementNumber,
            $expectedKey,
            $expectedValue,
            $subjectKey,
            $subjectValue
        ));
    }
}
