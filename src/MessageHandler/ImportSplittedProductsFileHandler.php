<?php

namespace App\MessageHandler;

use App\Message\ImportSplittedProductsFile;
use Domain\Product\Job\CreateOrUpdateProduct;
use Domain\Product\Job\CreateProduct;
use Domain\Product\Job\GetProduct;
use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\Price;
use Domain\Product\StyleNumber;
use Domain\Product\SyncStatus;
use JsonMachine\JsonMachine;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ImportSplittedProductsFileHandler implements MessageHandlerInterface
{

    private CreateOrUpdateProduct $process;

    public function __construct(CreateOrUpdateProduct $process)
    {
        $this->process = $process;
    }

    public function __invoke(ImportSplittedProductsFile $message)
    {
        $products = JsonMachine::fromFile($message->getFileName());

        foreach ($products as $data) {
            $product = new Product(
                new StyleNumber($data['styleNumber']),
                $data['name'],
                new Price($data['price']['amount'], $data['price']['currency']),
                $data['images'],
                SyncStatus::undefined()
            );

            $this->process->__invoke($product);
        }

        unlink($message->getFileName());
    }
}
