<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native;

use Kiboko\Cloud\Domain\Packaging;

final class Tag implements Packaging\Tag\TagBuildInterface
{
    private Packaging\RepositoryInterface $repository;
    private Packaging\Placeholder $name;
    private Packaging\Context\BuildableContextInterface $context;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Context\BuildableContextInterface $context
    ) {
        $this->repository = $repository;
        $this->name = new Packaging\Placeholder('%php.version%-%php.flavor%', $context->getArrayCopy());
        $this->context = $context;
    }

    public function getContext(): Packaging\Context\ContextInterface
    {
        return $this->context;
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
        $commands->add(new Packaging\Command\Build($this, $this->context));
    }

    public function forceBuild(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        $commands->add(new Packaging\Command\ForceBuild($this, $this->context));
    }
}