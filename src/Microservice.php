<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App;

use App\Model\Order;
use App\Writer\WriterInterface;

class Microservice
{
    private OrderRepository $repository;
    private WriterInterface $writer;

    public function __construct(OrderRepository $repository, WriterInterface $writer)
    {
        $this->repository = $repository;
        $this->writer = $writer;
    }

    /**
     * @throws \Exception
     */
    public function run(array $stock, string $ordersSourceFile): void
    {
        $orders = $this->repository->getFromFile($ordersSourceFile);
        $ordersToWrite = $this->filterOrders($stock, $orders);
        $this->writer->writeItems($ordersToWrite);
    }

    private function filterOrders(array $stock, array $orders): array
    {
        return \array_filter($orders, function (Order $order) use ($stock) {
            return  $stock[$order->getProductId()] >= $order->getQuantity();
        });
    }
}