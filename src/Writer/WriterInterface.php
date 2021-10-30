<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Writer;

interface WriterInterface
{
    /**
     * @param WritableInterface[] $items
     */
    public function writeItems(array $items): void;
}