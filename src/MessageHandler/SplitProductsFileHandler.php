<?php

namespace App\MessageHandler;

use App\Message\ImportSplittedProductsFile;
use App\Message\SplitProductsFile;
use JsonMachine\JsonMachine;
use League\Csv\Writer;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SplitProductsFileHandler implements MessageHandlerInterface
{

    const FILE_SIZE = 1000;

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(SplitProductsFile $message)
    {
        $count = 0;
        $appendix = 1;

        $splitted_filename = $message->getFileName() . '_' . $appendix . '.json';


        $output = [];

        $products = JsonMachine::fromFile($message->getFileName());

        foreach ($products as $product) {
            if ($count == self::FILE_SIZE) {
                file_put_contents($splitted_filename, json_encode($output));

                $count = 0;
                $appendix++;
                $output = [];
                $this->bus->dispatch(new ImportSplittedProductsFile($splitted_filename));

                $splitted_filename = $message->getFileName() . '_' . $appendix . '.json';
            }
            $output[] = $product;

            $count++;
        }

        if ($count > 0) {
            file_put_contents($splitted_filename, json_encode($output));

            $this->bus->dispatch(new ImportSplittedProductsFile($splitted_filename));
        }

        unlink($message->getFileName());
    }
}
