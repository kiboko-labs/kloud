<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\DTO;

use Kiboko\Cloud\Domain\Stack\Compose;
use Kiboko\Cloud\Domain\Stack\Diff\StackDiff;
use SebastianBergmann\Comparator\Factory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class Stack
{
    public Context $context;
    public Compose\Stack $stack;
    /** @var iterable|FileCommandInterface[] */
    public iterable $files;
    /** @var iterable|Compose\ValuedEnvironmentVariableInterface[] */
    public iterable $environment;

    public function __construct(Context $context, Compose\Stack $stack, FileCommandInterface ...$files)
    {
        $this->context = $context;
        $this->stack = $stack;
        $this->files = $files;
        $this->environment = [];
    }

    public function addFiles(FileCommandInterface ...$files): self
    {
        array_push($this->files, ...$files);

        return $this;
    }

    public function addEnvironmentVariables(Compose\ValuedEnvironmentVariableInterface ...$environmentVariables): self
    {
        array_push($this->environment, ...$environmentVariables);

        return $this;
    }

    public function addServices(Compose\Service ...$services): self
    {
        $this->stack->addServices(...$services);

        return $this;
    }

    public function removeServices(Compose\Service ...$services): self
    {
        $this->stack->removeServices(...$services);

        return $this;
    }

    public function replaceServices(Compose\Service ...$services): self
    {
        $this->stack->replaceServices(...$services);

        return $this;
    }

    public function addVolumes(Compose\Volume ...$volumes): self
    {
        $this->stack->addVolumes(...$volumes);

        return $this;
    }

    public function removeVolumes(Compose\Volume ...$volumes): self
    {
        $this->stack->removeVolumes(...$volumes);

        return $this;
    }

    public function replaceVolumes(Compose\Volume ...$volumes): self
    {
        $this->stack->replaceVolumes(...$volumes);

        return $this;
    }

    public function compareWith(string $path): StackDiff
    {
        $serializer = new Serializer(
            [
                new Compose\Normalizer\StackDenormalizer(),
                new Compose\Normalizer\ServiceDenormalizer(),
                new CustomNormalizer(),
                new PropertyNormalizer(),
                new ObjectNormalizer(),
            ],
            [
                new YamlEncoder()
            ]
        );

        $finder = (new Finder())
            ->files()
            ->in($path)
            ->name('/^docker-compose.ya?ml$/');

        if ($finder->hasResults()) {
            /** @var \SplFileInfo $file */
            foreach ($finder as $file) {
                try {
                    /** @var Compose\Stack $from */
                    $from = $serializer->deserialize($file->getContents(), Compose\Stack::class, 'yaml');
                } catch (\Throwable $exception) {
                    continue;
                }
                break;
            }
        }

        if (!isset($from)) {
            $from = new Compose\Stack();
        }

        return new StackDiff($from, $this->stack);
    }

    public function saveTo(string $path): void
    {
        $serializer = new Serializer(
            [
                new Compose\Normalizer\StackDenormalizer(),
                new Compose\Normalizer\ServiceDenormalizer(),
                new CustomNormalizer(),
                new PropertyNormalizer(),
                new ObjectNormalizer(),
            ],
            [
                new YamlEncoder()
            ]
        );

        file_put_contents(
            $path . '/docker-compose.yml',
            $serializer->serialize($this->stack, 'yaml', [
                'yaml_inline' => 4,
                'yaml_indent' => 0,
                'yaml_flags' => 0
            ])
        );

        foreach ($this->files as $file) {
            $file->saveTo($path);
        }

        $stream = fopen($path . '.env.dist', 'w');
        foreach ($this->environment as $environmentVariable) {
            fprintf($stream, '%s=%s' . PHP_EOL, $environmentVariable->getVariable()->name, (string) $environmentVariable->getValue());
        }
        fclose($stream);
    }
}