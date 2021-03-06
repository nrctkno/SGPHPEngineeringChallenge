<?php

namespace App\Command;

use App\Factory\FakeJSONFileCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductsFileCreateCommand extends Command
{

    protected static $defaultName = 'app:productsfile:create';

    function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new fake products file in json format.')
            ->setHelp('Example: php bin/console app:productsfile:create 5000 data/products.json')
            ->addArgument('count', InputArgument::REQUIRED, 'The number of records to create.')
            ->addArgument('path', InputArgument::REQUIRED, 'The path for the output file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $input->getArgument('count');
        $path = $input->getArgument('path');

        try {
            FakeJSONFileCreator::create($path, $count);

            $output->writeln($count . ' records created in "' . $path . '".');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
