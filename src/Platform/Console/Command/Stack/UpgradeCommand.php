<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Stack;

use Kiboko\Cloud\Domain\Packaging\Repository;
use Kiboko\Cloud\Domain\Stack\DTO\Context;
use Kiboko\Cloud\Domain\Stack\OroPlatform;
use Kiboko\Cloud\Domain\Stack\StackBuilder;
use Kiboko\Cloud\Platform\Console\ServicePrinter;
use Kiboko\Cloud\Platform\Console\ContextWizard;
use Kiboko\Cloud\Platform\Console\VolumePrinter;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class UpgradeCommand extends Command
{
    public static $defaultName = 'stack:upgrade';

    private string $configPath;
    private string $stacksPath;
    private ContextWizard $wizard;

    public function __construct(string $configPath, string $stacksPath, ?string $name = null)
    {
        $this->configPath = $configPath;
        $this->stacksPath = $stacksPath;
        $this->wizard = new ContextWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Initialize the Docker stack in a project without Docker stack');

        $this->wizard->configureConsoleCommand($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDirectory = $input->getOption('working-directory') ?: getcwd();

        $finder = (new Finder())
            ->files()
            ->ignoreDotFiles(false)
            ->in($workingDirectory);

        $format = new SymfonyStyle($input, $output);

        $serializer = new Serializer(
            [
                new PropertyNormalizer(),
            ],
            [
                new YamlEncoder()
            ]
        );

        if ($finder->hasResults()) {
            /** @var SplFileInfo $file */
            foreach ($finder->name('/^\.?kloud.ya?ml$/') as $file) {
                try {
                    /** @var Context $context */
                    $context = $serializer->deserialize($file->getContents(), Context::class, 'yaml');
                } catch (\Throwable $exception) {
                    continue;
                }

                break;
            }
        }

        if (!isset($context)) {
            $context = ($this->wizard)($input, $output);

            $format->note('Writing a new .kloud.yaml file.');
            file_put_contents($workingDirectory . '/.kloud.yaml', $serializer->serialize($context, 'yaml', [
                'yaml_inline' => 2,
                'yaml_indent' => 2,
                'yaml_flags' => 0
            ]));
        }

        $builder = new StackBuilder(
            new OroPlatform\Builder(
                new Repository($input->getOption('php-repository')),
                $this->stacksPath
            ),
        );

        $stack = $builder->build($context);

        $diff = $stack->compareWith($workingDirectory);

        $printer = new ServicePrinter();
        if (($missingServicesCount = count($missingServices = $diff->missingServices())) > 0) {
            $format->note(strtr('Your stack is missing %count% services.', ['%count%' => $missingServicesCount]));

            foreach ($missingServices as $service) {
                $printer->printService($service, $input, $output);

                if ($format->askQuestion(new ConfirmationQuestion('Do you wish to add this service to your stack?'))) {
                    $stack->addServices($service);
                }
            }
        }

        if (($extraServicesCount = count($extraServices = $diff->extraServices())) > 0) {
            $format->note(strtr('Your stack is having %count% non-standard services.', ['%count%' => $extraServicesCount]));

            foreach ($extraServices as $service) {
                if (in_array($service->getName(), $context->selfManagedServices)) {
                    $format->note(strtr('Ignoring service %serviceName% as it is marked as self-managed.', ['%serviceName%' => $service->getName()]));
                    continue;
                }
                $printer->printService($service, $input, $output);

                if (!$format->askQuestion(new ConfirmationQuestion('Do you wish to keep this service in your stack?'))) {
                    $stack->removeServices($service);
                }
            }
        }

        $updatedServicesCount = 0;
        if (count($commonServices = $diff->diffServices()) > 0) {
            foreach ($commonServices as $serviceDiff) {
                $diffChunks = $serviceDiff->diff();

                $differences = array_filter($diffChunks->getChunks(), function (array $chunk) {
                    return $chunk[1] === Differ::ADDED || $chunk[1] === Differ::REMOVED;
                });

                if (count($differences) <= 0) {
                    continue;
                }

                if (in_array($serviceDiff->getName(), $context->selfManagedServices)) {
                    $format->note(strtr('Ignoring service %serviceName% as it is marked as self-managed.', ['%serviceName%' => $serviceDiff->getName()]));
                    $stack->replaceServices($serviceDiff->getFrom());
                    continue;
                }

                $format->title(strtr('Service %service%', ['%service%' => $serviceDiff->getName()]));

                $printer->printServiceDiff($diffChunks, $input, $output);

                ++$updatedServicesCount;
                if (!$format->askQuestion(new ConfirmationQuestion('Do you wish to update this service in your stack?'))) {
                    $stack->replaceServices($serviceDiff->getFrom());
                }
            }
        }

        $printer = new VolumePrinter();
        if (($missingVolumesCount = count($missingVolumes = $diff->missingVolumes())) > 0) {
            $format->note(strtr('Your stack is missing %count% volumes.', ['%count%' => $missingVolumesCount]));

            foreach ($missingVolumes as $volume) {
                $printer->printVolume($volume, $input, $output);

                if ($format->askQuestion(new ConfirmationQuestion('Do you wish to add this volume to your stack?'))) {
                    $stack->addVolumes($volume);
                }
            }
        }

        if (($extraVolumesCount = count($extraVolumes = $diff->extraVolumes())) > 0) {
            $format->note(strtr('Your stack is having %count% non-standard volumes.', ['%count%' => $extraVolumesCount]));

            foreach ($extraVolumes as $volume) {
                if (in_array($volume->getName(), $context->selfManagedVolumes)) {
                    $format->note(strtr('Ignoring volume %volumeName% as it is marked as self-managed.', ['%volumeName%' => $volume->getName()]));
                    continue;
                }
                $printer->printVolume($volume, $input, $output);

                if (!$format->askQuestion(new ConfirmationQuestion('Do you wish to keep this volume in your stack?'))) {
                    $stack->removeVolumes($volume);
                }
            }
        }

        $updatedVolumesCount = 0;
        if (count($commonVolumes = $diff->diffVolumes()) > 0) {
            foreach ($commonVolumes as $volumeDiff) {
                $diffChunks = $volumeDiff->diff();

                $differences = array_filter($diffChunks->getChunks(), function (array $chunk) {
                    return $chunk[1] === Differ::ADDED || $chunk[1] === Differ::REMOVED;
                });

                if (count($differences) <= 0) {
                    continue;
                }

                if (in_array($volumeDiff->getName(), $context->selfManagedVolumes)) {
                    $format->note(strtr('Ignoring volume %volumeName% as it is marked as self-managed.', ['%volumeName%' => $volumeDiff->getName()]));
                    $stack->replaceVolumes($volumeDiff->getFrom());
                    continue;
                }

                $format->title(strtr('Volume %volume%', ['%volume%' => $volumeDiff->getName()]));

                $printer->printVolumeDiff($diffChunks, $input, $output);

                ++$updatedVolumesCount;
                if (!$format->askQuestion(new ConfirmationQuestion('Do you wish to update this volume in your stack?'))) {
                    $stack->replaceVolumes($volumeDiff->getFrom());
                }
            }
        }

        if (($missingServicesCount + $extraServicesCount + $updatedServicesCount + $missingVolumesCount + $extraVolumesCount + $updatedVolumesCount) <= 0) {
            $format->success('Your stack was up to date.');
        }

        $finder = (new Finder())
            ->files()
            ->in($workingDirectory)
            ->name('/^docker-compose.ya?ml$/');

        if ($finder->hasResults()) {
            /** @var \SplFileInfo $file */
            foreach ($finder as $file) {
                $path = $file->getPath();
                break;
            }
        } else {
            $path = $workingDirectory;
        }

        $stack->saveTo($path);

        return 0;
    }
}
