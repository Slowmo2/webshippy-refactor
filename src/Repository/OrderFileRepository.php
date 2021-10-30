<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Repository;

use App\FileReader\FileReaderInterface;
use App\Model\Order;
use App\Sort\OrderSorterInterface;

final class OrderFileRepository extends AbstractOrderRepository
{
    private FileReaderInterface $fileReader;
    private string $fileName;

    public function __construct(FileReaderInterface $fileReader, string $fileName, ?OrderSorterInterface $sorter = null)
    {
        $this->fileReader = $fileReader;
        $this->fileName = $fileName;
        parent::__construct($sorter);
    }

    /**
     * @throws \Exception
     * @return Order[]
     */
    public function getOrders(): array
    {
        $orderData = $this->fileReader->read($this->fileName);

        return $this->sort($this->transform($orderData));
    }
}