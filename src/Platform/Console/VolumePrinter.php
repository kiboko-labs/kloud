<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console;

use Kiboko\Cloud\Domain\Stack\Compose\Volume;
use Kiboko\Cloud\Domain\Stack\Diff\VolumeDiff;
use Kiboko\Cloud\Domain\Stack\Diff\UnifiedDiffOutputBuilder;
use SebastianBergmann\Diff\Diff;
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

    public function printVolumeDiff(Diff $diff, InputInterface $input, OutputInterface $output): void
    {
        $format = new SymfonyStyle($input, $output);

        $format->write((string) (new UnifiedDiffOutputBuilder())->getDiff($diff->getChunks()));
    }
}