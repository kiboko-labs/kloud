<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Command;

use Builder\Domain\Packaging;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Process\Process;

final class ForceBuild implements CommandInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private Packaging\Tag\TagInterface $tag;
    private Packaging\Context\BuildableContextInterface $context;

    public function __construct(
        Packaging\Tag\TagInterface $tag,
        Packaging\Context\BuildableContextInterface $context
    ) {
        $this->tag = $tag;
        $this->context = $context;
    }

    public function __toString()
    {
        return sprintf('FORCE BUILD %s:%s', (string) $this->tag->getRepository(), (string) $this->tag);
    }

    public function __invoke(): Process
    {
        return new Process(
            [
                'docker', 'build',
//                '--pull',
                '--no-cache',
                '--tag', sprintf('%s:%s', (string) $this->tag->getRepository(), (string) $this->tag),
                $this->context->getPath(),
            ],
            null,
            null,
            null,
            3600.0
        );
    }
}
