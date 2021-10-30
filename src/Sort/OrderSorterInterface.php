<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Sort;

use App\Model\Order;

interface OrderSorterInterface
{
    public function sort(Order $a, Order $b): int;
}