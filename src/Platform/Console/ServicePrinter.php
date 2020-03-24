<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariableInterface;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\ValuedEnvironmentVariableInterface;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\Diff\ServiceDiff;
use Kiboko\Cloud\Domain\Stack\Diff\UnifiedDiffOutputBuilder;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ServicePrinter
{
    public function printService(Service $service, InputInterface $input, OutputInterface $output): void
    {
        $format = new SymfonyStyle($input, $output);

        $format->title(strtr('Service %service%', ['%service%' => $service->getName()]));

        $format->table(
            ['name', 'image', 'inherits from', 'build context'],
            [[$service->getName(), $service->getImage() ?? '<none>', $service->getExtendedService() ?? '<none>', $service->getBuildContext() ?? '<none>']]
        );

        if (count($service->getVolumesMappings())) {
            $format->writeln('Volumes:');
            $format->table(
                ['path in host', 'path in container', 'extra'],
                array_map(function (VolumeMapping $volume) {
                    return [$volume->getHostPath(), $volume->getContainerPath(), !$volume->isReadonly() ?: 'readonly'];
                }, $service->getVolumesMappings())
            );
        }

        if (count($service->getPorts())) {
            $format->writeln('Ports:');
            $format->table(
                ['port on host', 'port on container'],
                array_map(function (PortMapping $port) {
                    return [$port->getPortOnHost(), $port->getPortOnContainer()];
                }, $service->getPorts())
            );
        }

        if (count($service->getEnvironmentVariables())) {
            $format->writeln('Environment Variables:');
            $format->table(
                ['variable', 'value'],
                array_map(function (EnvironmentVariableInterface $environmentVariable) {
                    return [
                        $environmentVariable->getVariable()->name,
                        $environmentVariable instanceof ValuedEnvironmentVariableInterface ? sprintf('"%s"', $environmentVariable->getValue()) : ''
                    ];
                }, $service->getEnvironmentVariables())
            );
        }
    }

    public function printServiceDiff(ServiceDiff $serviceDiff, InputInterface $input, OutputInterface $output): bool
    {
        $diff = $serviceDiff->diff();
        $differences = array_filter($diff->getChunks(), function (array $chunk) {
            return $chunk[1] === Differ::ADDED || $chunk[1] === Differ::REMOVED;
        });

        if (count($differences) <= 0) {
            return false;
        }

        $format = new SymfonyStyle($input, $output);

        $format->title(strtr('Service %service%', ['%service%' => $serviceDiff->getName()]));

        $format->write((string) (new UnifiedDiffOutputBuilder())->getDiff($diff->getChunks()));

        return true;
    }
}