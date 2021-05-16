<?php

namespace App\Command;

use App\Message\SplitProductsFile;
use Domain\Product\Mock\FakeJSONFileCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateFakeProductsFileCommand extends Command
{

    protected static $defaultName = 'app:create-fake-products-file';

    private MessageBusInterface $bus;

    function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new fake products file in json format.')
            ->setHelp('Example: php bin/console php bin/console app:create-fake-products-file 5000 data/products.json')
            ->addArgument('count', InputArgument::REQUIRED, 'The number of records to create.')
            ->addArgument('path', InputArgument::REQUIRED, 'The path for the output file.')
            ->addOption('no-process', 'np', InputOption::VALUE_OPTIONAL, 'When the command should not subscribe the file to be processed.', false)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $input->getArgument('count');
        $path = $input->getArgument('path');
        $no_process = $input->getOption('no-process');

        try {
            FakeJSONFileCreator::create($path, $count);

            $output->writeln($count . ' records created in "' . $path . '".');

            if ($no_process === false) {
                $this->bus->dispatch(new SplitProductsFile($path));
                $output->writeln('File was dispatched to process.');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
