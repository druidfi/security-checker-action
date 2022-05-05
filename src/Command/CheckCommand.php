<?php

namespace App\Command;

use App\Service\MarkdownService;
use App\Service\UpdateService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;

class CheckCommand extends Command
{
    protected static $defaultName = 'check';

    protected function configure()
    {
        $this
            ->addOption(
                'lock',
                'l',
                InputOption::VALUE_REQUIRED,
                'The path to the composer.lock file',
                './composer.lock'
            )
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_REQUIRED,
                'The output format (json by default, supported: markdown, json, print_r, or yaml)',
                'json'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock_file = $input->getOption('lock');

        if (!file_exists($lock_file)) {
            $output->writeln(sprintf('<error>Unable to read %s</error>', $lock_file));

            return Command::FAILURE;
        }

        $updateService = (new UpdateService())->setLockFile($lock_file);

        try {
            $updates = $updateService->checkUpdates();

            echo match ($input->getOption('format')) {
                'json' => (new JsonEncoder())->encode($updates, JsonEncoder::FORMAT),
                'yaml' => (new YamlEncoder())->encode($updates, YamlEncoder::FORMAT),
                'print_r' => print_r($updates, true),
                'markdown' => MarkdownService::render($updates),
            };

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }
    }
}