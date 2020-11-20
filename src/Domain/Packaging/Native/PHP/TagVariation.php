<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native\PHP;

use Kiboko\Cloud\Domain\Packaging;

final class TagVariation implements Packaging\Tag\TagBuildInterface, Packaging\Tag\DependentTagInterface
{
    use Packaging\Tag\TagVariationTrait;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Tag\TagInterface $from,
        Packaging\Context\BuildableContextInterface $context
    ) {
        $this->repository = $repository;
        $this->name = new Packaging\Placeholder('%php.version%-%php.flavor%-%package.variation%', $context->getArrayCopy());
        $this->context = $context;
        $this->from = $from;
    }
}
