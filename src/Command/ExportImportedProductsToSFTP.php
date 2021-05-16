<?php

namespace App\Command;

use Domain\Product\Port\ProductReader;
use Domain\Product\Port\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportImportedProductsToSFTP extends Command
{

    protected static $defaultName = 'app:export-imported-products-to-sftp';

    private ProductReader $reader;
    private ProductRepository $repository;

    function __construct(ProductReader $reader, ProductRepository $repository)
    {
        $this->reader = $reader;
        $this->repository = $repository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new fake products file in json format.')
            ->setHelp('Example: php bin/console php bin/console app:export-imported-products-to-sftp');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $imported_products = $this->reader->getImportedProducts();

        $writer = Writer::createFromPath('data/imported.csv', 'w+');

        $writer->insertOne([
            'Product Id', 'Product Name', 'Price',
            'Image 1', 'Image 2', 'Image 3', 'Image 4', 'Image 5', 'Image 6', 'Image 7', 'Image 8', 'Image 9'
        ]);

        foreach ($imported_products as $product) {
            $writer->insertOne([
                $product['styleNumber'],
                $product['name'],
                '$' . $product['amount'],
                join(',', $product['images'])
            ]);
        }

        return Command::SUCCESS;
    }
}
