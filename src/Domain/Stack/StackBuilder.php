<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Stack\DTO\Context;

final class StackBuilder implements StackBuilderInterface
{
    /** @var iterable|DelegatedStackBuilderInterface[] */
    private iterable $builders;

    public function __construct(DelegatedStackBuilderInterface ...$builders)
    {
        $this->builders = $builders;
    }

    public function add(DelegatedStackBuilderInterface ...$builders): void
    {
        array_push($this->builders, $builders);
    }

    public function build(Context $context): DTO\Stack
    {
        foreach ($this->builders as $builder) {
            if (!$builder->matches($context)) {
                continue;
            }

            return $builder->build($context);
        }

        throw new \InvalidArgumentException('Provided context could not be built by any delegated builder.');
    }
}