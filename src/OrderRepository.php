<?php

namespace App;

use App\FileReader\FileReaderInterface;
use App\Model\Order;
use App\Sort\OrderSorterInterface;

class OrderRepository
{
    private FileReaderInterface $fileReader;
    private ?OrderSorterInterface $sorter;

    public function __construct(FileReaderInterface $fileReader, ?OrderSorterInterface $sorter = null)
    {
        $this->fileReader = $fileReader;
        $this->sorter = $sorter;
    }

    /**
     * @throws \Exception
     */
    public function getFromFile(string $sourceFileName): array
    {
        $orderData = $this->fileReader->read($sourceFileName);

        return $this->sort($this->transform($orderData));
    }

    /**
     * @param array $orderData
     * @return Order[]
     * @throws \Exception
     */
    private function transform(array $orderData): array
    {
        $orders = [];

        foreach ($orderData as $data) {
            $orders[] = Order::createFromArray($data);
        }

        return $orders;
    }

    private function sort(array $orders): array
    {
        if ($sorter = $this->sorter) {
            \usort($orders, function (Order $a, Order $b) use ($sorter) {
                return $sorter->sort($a, $b);
            });
        }

        return $orders;
    }
}