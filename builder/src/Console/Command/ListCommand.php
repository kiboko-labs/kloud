<?php declare(strict_types=1);

namespace Builder\Console\Command;

use Builder\BuildableTagInterface;
use Builder\Console\Wizard;
use Builder\DependentTagInterface;
use Builder\Package\PackageInterface;
use Builder\TagInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableRows;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ListCommand extends Command
{
    private string $configPath;

    public function __construct(string $name, string $configPath)
    {
        parent::__construct($name);
        $this->configPath = $configPath;
    }

    protected function configure()
    {
        $this->setName('list');
        $this->setDescription('List PHP Docker images');

        $this->addOption('regex', 'x', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($pattern = $input->getOption('regex'))) {
            $pattern = (new Wizard())($input, $output);
        }

        /** @var PackageInterface[] $packages */
        $packages = new \CachingIterator(new \ArrayIterator(array_merge(
            require $this->configPath . '/versions.php',
            require $this->configPath . '/packages.php',
        )), \CachingIterator::FULL_CACHE);
        $format = new SymfonyStyle($input, $output);

        $format->table(['tag', 'parent', 'path'], iterator_to_array(new TableRows(function() use ($pattern, $packages, $input) {
            /** @var PackageInterface $package */
            foreach ($packages as $package) {
                $tags = new \IteratorIterator($package);
                if (!empty($pattern)) {
                    $tags = new \CallbackFilterIterator($tags, function (TagInterface $tag) use ($pattern) {
                        return preg_match($pattern, (string)$tag) > 0;
                    });
                }

                foreach ($tags as $tag) {
                    yield [
                        'tag' => !empty($pattern) ? preg_replace($pattern, '<comment>\0</>', (string) $tag) : (string) $tag,
                        'parent' => $tag instanceof DependentTagInterface ? $tag->getParent() : null,
                        'path' => $tag instanceof BuildableTagInterface ? $tag->getPath() : null,
                    ];
                }
            }
        })));

        return 0;
    }
}