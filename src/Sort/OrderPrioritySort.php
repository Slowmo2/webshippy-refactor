<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Sort;

use App\Model\Order;

final class OrderPrioritySort implements OrderSorterInterface
{
    public function sort(Order $a, Order $b): int
    {
        $pc = -1 * ($a->getPriority() <=> $b->getPriority());

        return $pc == 0 ? $a->getCreatedAt() <=> $b->getCreatedAt() : $pc;
    }
}