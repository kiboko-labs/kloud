<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console\Command\Environment;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InitCommand extends Command
{
    public static $defaultName = 'environment:init';

    protected function configure()
    {
        $this->setDescription('Initialize the environment file in local workspace');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $format = new SymfonyStyle($input, $output);
        $allLines = [];

        $serverAddress = $format->askQuestion(new Question('Server of your remote directory'));
        $newLine = 'SERVER_ADDRESS' . ': ' . $serverAddress . PHP_EOL;
        array_push($allLines, $newLine);

        $depPath = $format->askQuestion(new Question('Path of your remote directory on the server'));
        $newLine = 'DEPLOYMENT_PATH' . ': ' . $depPath . PHP_EOL;
        array_push($allLines, $newLine);

        $envDistPath = getcwd() . '/.env.dist';
        if (file_exists($envDistPath)) {
            $envDist = parse_ini_file($envDistPath);
            foreach (array_keys($envDist) as $line) {
                $lineValue = $format->askQuestion(new Question('Value of ' . $line));
                $newLine = $line . ': ' . $lineValue . PHP_EOL;
                array_push($allLines, $newLine);
            }
        }

        $newFile = fopen('.kloud.environent.yaml', 'w');
        foreach ($allLines as $line) {
            fwrite($newFile, $line);
        }

        return 0;
    }
}
