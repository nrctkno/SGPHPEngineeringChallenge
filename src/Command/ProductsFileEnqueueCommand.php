<?php

namespace App\Command;

use App\Message\SplitProductsFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductsFileEnqueueCommand extends Command
{

    protected static $defaultName = 'app:productsfile:enqueue';

    private MessageBusInterface $bus;

    function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Enqueues a products file to be processed.')
            ->setHelp('Example: php bin/console app:productsfile:enqueue data/products.json')
            ->addArgument('path', InputArgument::REQUIRED, 'The path of the file to process.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $path = $input->getArgument('path');

        try {
            $this->bus->dispatch(new SplitProductsFile($path));
            $output->writeln(sprintf('File %s was dispatched to process.', $path));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
