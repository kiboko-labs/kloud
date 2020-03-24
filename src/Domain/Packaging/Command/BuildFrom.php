<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Command;

use Builder\Domain\Packaging;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Process\Process;

final class BuildFrom implements CommandInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private Packaging\Tag\TagInterface $tag;
    private Packaging\Tag\TagInterface $source;
    private Packaging\Context\BuildableContextInterface $context;

    public function __construct(
        Packaging\Tag\TagInterface $tag,
        Packaging\Tag\TagInterface $source,
        Packaging\Context\BuildableContextInterface $context
    ) {
        $this->tag = $tag;
        $this->source = $source;
        $this->context = $context;
    }

    public function __toString()
    {
        return sprintf('BUILD %1$s:%2$s FROM %1$s:%3$s', (string) $this->tag->getRepository(), (string) $this->tag, (string) $this->source);
    }

    public function __invoke(): Process
    {
        return new Process(
            [
                'docker', 'build',
//                '--pull',
                '--tag', sprintf('%s:%s', (string) $this->tag->getRepository(), (string) $this->tag),
                '--build-arg', sprintf('SOURCE_VARIATION=%s', (string) $this->source),
                $this->context->getPath(),
            ],
            null,
            null,
            null,
            3600.0
        );
    }
}
