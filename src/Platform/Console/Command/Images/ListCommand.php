<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Images;

use Kiboko\Cloud\Domain\Packaging;
use Kiboko\Cloud\Platform\Console\ContextWizard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ListCommand extends Command
{
    public static $defaultName = 'images:list';

    private string $configPath;
    private ContextWizard $wizard;

    public function __construct(
        string $configPath,
        ?string $name = null
    ) {
        $this->configPath = $configPath;
        $this->wizard = new ContextWizard();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('List PHP Docker images');

        $this->addOption('php-images-regex', 'x', InputOption::VALUE_REQUIRED);

        $this->addOption('dbgp-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/dbgp');
        $this->addOption('postgresql-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/postgresql');
        $this->addOption('php-repository', null, InputOption::VALUE_REQUIRED, 'Set your Docker Image repository name for PHP.', 'kiboko/php');
        $this->addOption('with-experimental', 'E', InputOption::VALUE_NONE, 'Enable Experimental images and PHP versions.');

        $this->wizard->configureConsoleCommand($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('php-images-regex'))) {
            $pattern = ($this->wizard)($input, $output)->getPHPImagesRegex();
        }

        $format = new SymfonyStyle($input, $output);

        $packages = Packaging\Config\Config::builds(
            $this->configPath,
            new Packaging\Repository($input->getOption('dbgp-repository')),
            new Packaging\Repository($input->getOption('postgresql-repository')),
            new Packaging\Repository($input->getOption('php-repository')),
            (bool) $input->getOption('with-experimental')
        );

        $format->table(['tag', 'parent', 'path'], iterator_to_array((function () use ($pattern, $packages) {
            /** @var Packaging\PackageInterface $package */
            foreach ($packages as $package) {
                $tags = new \IteratorIterator($package);
                if (!empty($pattern)) {
                    $tags = new \CallbackFilterIterator($tags, function (Packaging\Tag\TagInterface $tag) use ($pattern) {
                        return preg_match($pattern, (string) $tag) > 0;
                    });
                }

                foreach ($tags as $tag) {
                    yield [
                        'tag' => !empty($pattern) ? preg_replace($pattern, '<comment>\0</>', (string) $tag) : (string) $tag,
                        'parent' => $tag instanceof Packaging\Tag\DependentTagInterface ? $tag->getParent() : null,
                        'path' => ($context = $tag->getContext()) instanceof Packaging\Context\BuildableContextInterface ? $context->getPath() : null,
                    ];
                }
            }
        })()));

        return 0;
    }
}
