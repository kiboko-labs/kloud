<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Stack;

use Kiboko\Cloud\Domain\Packaging\Repository;
use Kiboko\Cloud\Domain\Stack\OroPlatform;
use Kiboko\Cloud\Domain\Stack\StackBuilder;
use Kiboko\Cloud\Platform\Console\ContextWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class InitCommand extends Command
{
    public static $defaultName = 'stack:init';

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
            /** @var \SplFileInfo $file */
            foreach ($finder->name('/^\.?kloud.ya?ml$/') as $file) {
                $format->error('The directory was already initialized with a Docker stack. You should instead run stack:upgrade command.');
                return 0;
            }
        }

        $context = ($this->wizard)($input, $output);

        $format->note('Writing a new .kloud.yaml file.');
        file_put_contents($workingDirectory . '/.kloud.yaml', $serializer->serialize($context, 'yaml', [
            'yaml_inline' => 2,
            'yaml_indent' => 2,
            'yaml_flags' => 0
        ]));

        $builder = new StackBuilder(
            new OroPlatform\Builder(new Repository($input->getOption('repository')), $this->stacksPath),
        );

        $stack = $builder->build($context);

        $stack->saveTo($workingDirectory);

        return 0;
    }
}
