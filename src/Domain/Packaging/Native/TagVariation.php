<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native;

use Kiboko\Cloud\Domain\Packaging;

final class TagVariation implements Packaging\Tag\TagBuildInterface, Packaging\Tag\DependentTagInterface
{
    private Packaging\RepositoryInterface $repository;
    private Packaging\Placeholder $name;
    private Packaging\Context\BuildableContextInterface $context;
    private Packaging\Tag\TagInterface $from;

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

    public function getContext(): Packaging\Context\ContextInterface
    {
        return $this->context;
    }

    public function getParent(): Packaging\Tag\TagInterface
    {
        return $this->from;
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getRepository(): Packaging\RepositoryInterface
    {
        return $this->repository;
    }

    public function pull(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        $commands->add(new Packaging\Command\Pull($this));
    }

    public function push(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        $commands->add(new Packaging\Command\Push($this));
    }

    public function build(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        $commands->add(new Packaging\Command\BuildFrom($this, $this->from, $this->context));
    }

    public function forceBuild(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        $commands->add(new Packaging\Command\ForceBuildFrom($this, $this->from, $this->context));
    }
}