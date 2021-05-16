<?php

namespace App\MessageHandler;

use App\Message\ImportSplittedProductsFile;
use Domain\Product\Job\CreateProduct;
use Domain\Product\Job\GetProduct;
use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\Price;
use Domain\Product\StyleNumber;
use JsonMachine\JsonMachine;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ImportSplittedProductsFileHandler implements MessageHandlerInterface
{

    private CreateProduct $create_product;
    private GetProduct $get_product;

    public function __construct(GetProduct $get_product, CreateProduct $create_product)
    {
        $this->create_product = $create_product;
        $this->get_product = $get_product;
    }

    public function __invoke(ImportSplittedProductsFile $message)
    {
        $products = JsonMachine::fromFile($message->getFileName());

        foreach ($products as $data) {
            $existing = $this->get_product->__invoke(new StyleNumber($data['styleNumber']));

            $new = new Product(
                new StyleNumber($data['styleNumber']),
                $data['name'],
                new Price($data['price']['amount'], $data['price']['currency']),
                $data['images']
            );

            if ($new == $existing) {
                $this->update_product->__invoke($new);
                continue;
            }

            if (is_null($existing)) {
                $this->create_product->__invoke($new);
                continue;
            }
        }

        unlink($message->getFileName());
    }
}
