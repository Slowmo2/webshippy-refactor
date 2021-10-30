<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Writer;

final class Printer implements WriterInterface
{
    private const PADDING = 20;
    private const SEPARATOR = "=";

    /**
     * @param WritableInterface[] $items
     */
    public function writeItems(array $items): void
    {
        if (\count($items) === 0) {
            return;
        }

        $firstItem = \reset($items);
        $this->printHeader($firstItem);
        $this->printSeparator($firstItem);
        $this->printItems($items);
    }

    private function printHeader(WritableInterface $item): void
    {
        foreach ($item::getHeader() as $headerColumn) {
            echo \str_pad($headerColumn.'', self::PADDING);
        }

        $this->breakLine();
    }

    private function printSeparator(WritableInterface $item): void
    {
        echo \str_repeat(self::SEPARATOR, \count($item::getHeader()) * self::PADDING);

        $this->breakLine();
    }

    /**
     * @param WritableInterface[] $items
     */
    private function printItems(array $items): void
    {
        foreach ($items as $item) {
            foreach ($item->getLine() as $column) {
                echo \str_pad($column.'', self::PADDING);
            }

            $this->breakLine();
        }
    }

    private function breakLine(): void
    {
        echo "\n";
    }
}
