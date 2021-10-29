<?php

namespace App;

use App\Model\Order;

class OrderFilter
{
    private FileReaderInterface $fileReader;

    public function __construct(FileReaderInterface $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function filter(string $sourceFileName): array
    {
        $orders = [];
        $rawData = $this->fileReader->read($sourceFileName);

        foreach ($rawData as $data) {
            $orders[] = Order::createFromArray($data);
        }

        return $orders;

        // This is rather an order collection provider or something like that
    }
}