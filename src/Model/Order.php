<?php

namespace App\Model;

use http\Exception\InvalidArgumentException;

class Order
{
    private const PRIORITY_LOW = 'low';
    private const PRIORITY_MEDIUM = 'medium';
    private const PRIORITY_HIGH = 'high';

    private const PRIORITIES = [
        1 => self::PRIORITY_LOW,
        2 => self::PRIORITY_MEDIUM,
    ];

    private int $productId;
    private int $quantity;
    private int $priority;
    private \DateTime $createdAt;

    public static function createFromArray(array $data): self
    {
        if (
            !array_key_exists('productId', $data) ||
            !array_key_exists('quantity', $data) ||
            !array_key_exists('priority', $data) ||
            !array_key_exists('createdAt', $data)
        ) {
            throw new InvalidArgumentException('Malformed order data!');
        }

        $order = new self();
        $order->productId = $data['productId'];
        $order->quantity = $data['quantity'];
        $order->priority = $data['priority'];
        $order->createdAt = new \DateTime($data['createdAt']);

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