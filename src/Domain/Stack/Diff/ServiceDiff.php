<?php declare(strict_types=1);

namespace Builder\Domain\Stack\Diff;

use Builder\Domain\Stack\Compose;
use SebastianBergmann\Diff\Diff;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ServiceDiff
{
    private Compose\Service $from;
    private Compose\Service $to;

    public function __construct(Compose\Service $from, Compose\Service $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getName(): string
    {
        return $this->from->getName() ?? $this->to->getName();
    }

    public function diff(): Diff
    {
        $serializer = new Serializer(
            [
                new CustomNormalizer(),
                new PropertyNormalizer(),
            ],
            [
                new YamlEncoder()
            ]
        );

        $options = [
            'yaml_inline' => 4,
            'yaml_indent' => 0,
            'yaml_flags' => 0
        ];

        $differ = new Differ();
        $diff = $differ->diffToArray(
            $serializer->serialize($this->from, 'yaml', $options),
            $serializer->serialize($this->to, 'yaml', $options),
            );
        return new Diff('a/docker-compose.ynl', 'b/docker-compose.yml', $diff);
    }

    public function getFrom(): Compose\Service
    {
        return $this->from;
    }

    public function getTo(): Compose\Service
    {
        return $this->to;
    }
}