<?php

namespace App\Application\Console;

use App\Domain\PostalCode\PostalCodeRepository;
use App\Domain\PostalCode\Services\Imports\ImportPostalCodesFromZip;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportPostalCodesCommand extends Command
{
    private PostalCodeRepository $repository;

    public function __construct(PostalCodeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('app:postal_code:import');

        $this->setDescription('Import postal codes from zip (xlsx) file');

        $this->addArgument(
            'file_path',
            InputArgument::REQUIRED,
            'Path to the file with data about postal codes'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $time_start = microtime(true);

        try {
            $filePath = $input->getArgument('file_path');

            (new ImportPostalCodesFromZip($this->repository))->import($filePath);
        } catch (\Exception $exception) {
            $output->writeln(sprintf("<error>{$exception->getMessage()}</error>"));

            return 1;
        }

        $output->writeln(sprintf('<info>Success</info>'));

        $totalTimeMessage = 'Total execution time in seconds: ' . (microtime(true) - $time_start);
        $output->writeln(sprintf("<info>$totalTimeMessage</info>"));

        return 0;
    }
}
