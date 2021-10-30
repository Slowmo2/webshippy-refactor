<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Repository;

use App\Model\Order;
use App\Sort\OrderSorterInterface;

abstract class AbstractOrderRepository implements OrderRepositoryInterface
{
    private ?OrderSorterInterface $sorter;

    public function __construct(?OrderSorterInterface $sorter)
    {
        $this->sorter = $sorter;
    }

    /**
     * @param array $orderData
     * @return Order[]
     * @throws \Exception
     */
    protected function transform(array $orderData): array
    {
        $orders = [];

        foreach ($orderData as $data) {
            $orders[] = Order::createFromArray($data);
        }

        return $orders;
    }

    /**
     * @param Order[] $orders
     * @return Order[]
     */
    protected function sort(array $orders): array
    {
        if ($sorter = $this->sorter) {
            \usort($orders, function (Order $a, Order $b) use ($sorter) {
                return $sorter->sort($a, $b);
            });
        }

        return $orders;
    }
}
