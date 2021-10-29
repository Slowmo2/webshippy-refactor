<?php

namespace App;

use App\Model\Order;

interface OrderSorterInterface
{
    public function sort(Order $a, Order $b): int;
}