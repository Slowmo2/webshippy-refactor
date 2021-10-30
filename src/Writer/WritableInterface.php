<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\Writer;

interface WritableInterface
{
    public function getLine(): array;

    /**
     * @return string[]
     */
    public static function getHeader(): array;
}