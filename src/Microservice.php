<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App;

use App\Model\Order;
use App\Repository\OrderRepositoryInterface;
use App\Writer\WriterInterface;

final class Microservice
{
    private OrderRepositoryInterface $repository;
    private WriterInterface $writer;

    public function __construct(OrderRepositoryInterface $repository, WriterInterface $writer)
    {
        $this->repository = $repository;
        $this->writer = $writer;
    }

    /**
     * @throws \Exception
     */
    public function run(array $stock): void
    {
        $orders = $this->repository->getOrders();
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