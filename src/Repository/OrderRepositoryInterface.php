<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Repository;

use App\Model\Order;

interface OrderRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getOrders(): array;
}