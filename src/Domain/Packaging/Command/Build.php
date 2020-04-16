<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Command;

use Kiboko\Cloud\Domain\Packaging;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use splitbrain\PHPArchive\Tar;
use Symfony\Component\Process\Process;

final class Build implements CommandInterface, LoggerAwareInterface
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
        return sprintf('BUILD %s:%s', (string) $this->tag->getRepository(), (string) $this->tag);
    }

    public function __invoke(string $rootPath): Process
    {
        $archiver = new Packaging\Archiver();
        $archiver->addPath($rootPath . '/' . $this->context->getPath());

        return new Process(
            [
                'docker', 'build', '--rm',
                '--tag', sprintf('%s:%s', (string) $this->tag->getRepository(), (string) $this->tag),
                '-',
            ],
            null,
            null,
            (string) $archiver,
            3600.0
        );
    }
}
