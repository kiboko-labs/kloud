<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\DTO\Context;

interface ServiceBuilderInterface
{
    public function matches(Context $context): bool;
    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack;
}