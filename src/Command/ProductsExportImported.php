<?php

namespace App\Command;

use Domain\Product\Job\GetImportedProducts;
use Domain\Product\Job\MarkProductAsSynced;
use Domain\Product\Port\ProductReader;
use Domain\Product\StyleNumber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductsExportImported extends Command
{

    protected static $defaultName = 'app:productsexport:imported';

    private GetImportedProducts $get_products;
    private MarkProductAsSynced $mark_as_synced;

    function __construct(GetImportedProducts $get_products, MarkProductAsSynced $mark_as_synced)
    {
        $this->get_products = $get_products;
        $this->mark_as_synced = $mark_as_synced;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Exports the non-synced products to csv.')
            ->setHelp('Example: php bin/console php bin/console app:productsexport:imported');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $imported_products = $this->get_products->__invoke();

        $writer = Writer::createFromPath('data/imported.csv', 'w+');

        $writer->insertOne([
            'Product Id', 'Product Name', 'Price',
            'Image 1', 'Image 2', 'Image 3', 'Image 4', 'Image 5', 'Image 6', 'Image 7', 'Image 8', 'Image 9'
        ]);

        foreach ($imported_products as $record) {
            $id = $record['styleNumber'];

            $writer->insertOne([
                $id,
                $record['name'],
                '$' . $record['amount'],
                join(',', $record['images'])
            ]);

            $this->mark_as_synced->__invoke(new StyleNumber($id));
        }

        return Command::SUCCESS;
    }
}
