<?php

namespace App;

use App\Model\Order;

final class OrderPrioritySort implements OrderSorterInterface
{
    // This could be used by the order filter through the interface
    public function sort(Order $a, Order $b): int
    {
        $pc = -1 * ($a['priority'] <=> $b['priority']);

        return $pc == 0 ? $a['created_at'] <=> $b['created_at'] : $pc;
    }
}