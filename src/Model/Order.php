<?php

namespace App\Model;

class Order
{
    private const PRIORITY_LOW = 'low';
    private const PRIORITY_MEDIUM = 'medium';
    private const PRIORITY_HIGH = 'high';

    private const PRIORITIES = [
        1 => self::PRIORITY_LOW,
        2 => self::PRIORITY_MEDIUM,
    ];

    private const COL_PRODUCT_ID = 'product_id';
    private const COL_QUANTITY = 'quantity';
    private const COL_PRIORITY = 'priority';
    private const COL_CREATED_AT = 'created_at';

    private int $productId;
    private int $quantity;
    private int $priority;
    private \DateTime $createdAt;

    public static function createFromArray(array $data): self
    {
        if (
            !array_key_exists(self::COL_PRODUCT_ID, $data) ||
            !array_key_exists(self::COL_QUANTITY, $data) ||
            !array_key_exists(self::COL_PRIORITY, $data) ||
            !array_key_exists(self::COL_CREATED_AT, $data)
        ) {
            throw new \Exception('Malformed order data!');
        }

        $order = new self();
        $order->productId = $data[self::COL_PRODUCT_ID];
        $order->quantity = $data[self::COL_QUANTITY];
        $order->priority = $data[self::COL_PRIORITY];
        $order->createdAt = new \DateTime($data[self::COL_CREATED_AT]);

        return $order;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getPriorityText(): string
    {
        return self::PRIORITIES[$this->priority] ?? self::PRIORITY_HIGH;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}