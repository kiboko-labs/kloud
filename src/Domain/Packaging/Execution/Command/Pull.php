<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\Command;

use Kiboko\Cloud\Domain\Packaging;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Process\Process;

final class Pull implements CommandInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private Packaging\Tag\TagInterface $tag;

    public function __construct(Packaging\Tag\TagInterface $tag)
    {
        $this->tag = $tag;
    }

    public function __toString()
    {
        return sprintf('PULL %s:%s', (string) $this->tag->getRepository(), (string) $this->tag);
    }

    public function __invoke(string $rootPath): Process
    {
        return new Process(
            [
                'docker', 'pull', sprintf('%s:%s', (string) $this->tag->getRepository(), (string) $this->tag),
            ],
            null,
            null,
            null,
            3600.0
        );
    }
}
