<?php declare(strict_types=1);

namespace Builder\Platform\Console;

use Builder\Domain\Stack\Compose\Volume;
use Builder\Domain\Stack\Diff\VolumeDiff;
use Builder\Domain\Stack\Diff\UnifiedDiffOutputBuilder;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class VolumePrinter
{
    public function printVolume(Volume $volume, InputInterface $input, OutputInterface $output): void
    {
        $format = new SymfonyStyle($input, $output);

        $format->title(strtr('Volume %volume%', ['%volume%' => $volume->getName()]));

        $diff = new VolumeDiff(new Volume($volume->getName(), []), $volume);

        $format->table(
            ['name', 'config'],
            [[$volume->getName(), (new UnifiedDiffOutputBuilder())->getDiff($diff->diff()->getChunks())]]
        );
    }

    public function printVolumeDiff(VolumeDiff $volumeDiff, InputInterface $input, OutputInterface $output): bool
    {
        $diff = $volumeDiff->diff();
        $differences = array_filter($diff->getChunks(), function (array $chunk) {
            return $chunk[1] === Differ::ADDED || $chunk[1] === Differ::REMOVED;
        });

        if (count($differences) <= 0) {
            return false;
        }

        $format = new SymfonyStyle($input, $output);

        $format->title(strtr('Volume %volume%', ['%volume%' => $volumeDiff->getName()]));

        $format->write((string) (new UnifiedDiffOutputBuilder())->getDiff($diff->getChunks()));

        return true;
    }
}