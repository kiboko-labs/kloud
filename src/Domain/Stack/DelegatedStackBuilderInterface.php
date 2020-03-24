<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Stack\DTO\Context;

interface DelegatedStackBuilderInterface extends StackBuilderInterface
{
    public function matches(Context $context): bool;
}