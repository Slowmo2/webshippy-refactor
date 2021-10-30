<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Tests\Model;

require __DIR__.'/../../autoload.php';

use App\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Model\Order
 */
class OrderTest extends TestCase
{
    private const VALID_TEST_ARRAY = [
        'product_id' => 1,
        'quantity' => 2,
        'priority' => 3,
        'created_at' => '2021-10-30 12:23:33',
        'priority_text' => 'high', // Not used for creating the object, but we can confirm that we got the correct result from getPriorityText()
    ];

    private const PRIORITY_MAP = [
        1 => 'low',
        2 => 'medium',
        3 => 'high',
        4 => 'high',
        'dog' => 'high',
        -1 => 'high',
    ];

    private const INVALID_TEST_DATA = [
        [
            'quantity' => 2,
            'priority' => 3,
            'created_at' => '2021-10-30 12:23:33',
        ],
        [
            'product_id' => 1,
            'priority' => 3,
            'created_at' => '2021-10-30 12:23:33',
        ],
        [
            'product_id' => 1,
            'quantity' => 2,
            'created_at' => '2021-10-30 12:23:33',
        ],
        [
            'product_id' => 1,
            'quantity' => 2,
            'priority' => 3,
        ]
    ];

    /**
     * @covers \App\Model\Order::createFromArray
     * @covers \App\Model\Order::getProductId
     * @covers \App\Model\Order::getQuantity
     * @covers \App\Model\Order::getPriority
     * @covers \App\Model\Order::getCreatedAt
     * @covers \App\Model\Order::getPriorityText
     * @covers \App\Model\Order::getLine
     */
    public function testCreateFromArray(): void
    {
        $want = self::VALID_TEST_ARRAY;

        try {
            $orderObject = Order::createFromArray($want);
        } catch (\Exception $exception) {
            $this->fail('Could not create Order object from valid order data array!');
        }

        $this->assertEquals($want['product_id'], $orderObject->getProductId());
        $this->assertEquals($want['quantity'], $orderObject->getQuantity());
        $this->assertEquals($want['priority'], $orderObject->getPriority());
        $this->assertEquals($want['created_at'], $orderObject->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals($want['priority_text'], $orderObject->getPriorityText());

        // Since we have an order object we can go ahead and test the getLine() as well
        $this->assertEquals([$want['product_id'], $want['quantity'], $want['priority_text'], $want['created_at']], $orderObject->getLine());
    }

    /**
     * @covers \App\Model\Order::getHeader
     */
    public function testGetHeader()
    {
        $this->assertEquals(['product_id', 'quantity', 'priority', 'created_at'], Order::getHeader());
    }

    /**
     * @covers \App\Model\Order::createFromArray
     */
    public function testInvalidDataForCreateFromArray(): void
    {
        foreach (self::INVALID_TEST_DATA as $invalidTestData) {
            try {
                Order::createFromArray($invalidTestData);
            } catch (\Exception $exception) {
                $this->assertEquals('Malformed order data!', $exception->getMessage());
                continue;
            }

            $this->fail('Could create order object with invalid data!');
        }
    }

    /**
     * @covers \App\Model\Order::createFromArray
     */
    public function testPriorityText(): void
    {
        $want = self::VALID_TEST_ARRAY;

        foreach (self::PRIORITY_MAP as $priority => $text) {
            $want['priority'] = $priority;
            try {
                $orderObject = Order::createFromArray($want);
            } catch (\Exception $exception) {
                $this->fail('Could not create Order object from valid order data array!');
            }

            $this->assertEquals($text, $orderObject->getPriorityText());
        }
    }
}
