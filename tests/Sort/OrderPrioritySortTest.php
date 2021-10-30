<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Tests\Sort;

use App\Model\Order;
use App\Sort\OrderPrioritySort;
use PHPUnit\Framework\TestCase;

require __DIR__.'/../../autoload.php';

/**
 * @covers \App\Sort\OrderPrioritySort
 * @uses \App\Model\Order
 */
class OrderPrioritySortTest extends TestCase
{
    private const CASES = [
        [
            'a' => [
                'product_id' => 1,
                'quantity' => 2,
                'priority' => 3,
                'created_at' => '2021-10-30 12:23:33',
            ],
            'b' => [
                'product_id' => 2,
                'quantity' => 4,
                'priority' => 2,
                'created_at' => '2021-11-30 12:23:33',
            ],
            'want' => -1,
        ],
        [
            'a' => [
                'product_id' => 1,
                'quantity' => 2,
                'priority' => 3,
                'created_at' => '2021-10-30 12:23:33',
            ],
            'b' => [
                'product_id' => 2,
                'quantity' => 4,
                'priority' => 3,
                'created_at' => '2021-10-30 12:23:33',
            ],
            'want' => 0,
        ],
        [
            'a' => [
                'product_id' => 1,
                'quantity' => 2,
                'priority' => 3,
                'created_at' => '2021-10-30 12:23:33',
            ],
            'b' => [
                'product_id' => 2,
                'quantity' => 4,
                'priority' => 3,
                'created_at' => '2021-09-30 12:23:33',
            ],
            'want' => 1,
        ],
        [
            'a' => [
                'product_id' => 1,
                'quantity' => 2,
                'priority' => 3,
                'created_at' => '2021-09-30 12:23:33',
            ],
            'b' => [
                'product_id' => 2,
                'quantity' => 4,
                'priority' => 3,
                'created_at' => '2021-10-30 12:23:33',
            ],
            'want' => -1,
        ],
        [
            'a' => [
                'product_id' => 1,
                'quantity' => 2,
                'priority' => 1,
                'created_at' => '2021-10-30 12:23:33',
            ],
            'b' => [
                'product_id' => 2,
                'quantity' => 4,
                'priority' => 2,
                'created_at' => '2021-11-30 12:23:33',
            ],
            'want' => 1,
        ],
    ];

    public function testOrderPrioritySort(): void
    {
        $sorter = new OrderPrioritySort();

        foreach (self::CASES as $case) {
            try {
                $a = Order::createFromArray($case['a']);
                $b = Order::createFromArray($case['b']);
            } catch (\Throwable $throwable) {
                $this->fail('Could not create order object from valid order data');
            }

            $this->assertEquals($case['want'], $sorter->sort($a, $b));
        }
    }
}
