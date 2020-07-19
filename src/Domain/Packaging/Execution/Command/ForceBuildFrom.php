<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\Command;

use Kiboko\Cloud\Domain\Packaging;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Process\Process;

final class ForceBuildFrom implements CommandInterface, LoggerAwareInterface
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
        return sprintf('FORCE BUILD %1$s:%2$s FROM %1$s:%3$s', (string) $this->tag->getRepository(), (string) $this->tag, (string) $this->source);
    }

    public function __invoke(string $rootPath): Process
    {
        $archiver = new Packaging\Archiver();
        $archiver->addPath($rootPath . '/' . $this->context->getPath());

        return new Process(
            [
                'docker', 'build', '--rm',
                '--no-cache',
                '--tag', sprintf('%s:%s', (string) $this->tag->getRepository(), (string) $this->tag),
                '--build-arg', sprintf('SOURCE_VARIATION=%s', (string) $this->source),
                '-',
            ],
            null,
            null,
            (string) $archiver,
            3600.0
        );
    }
}
