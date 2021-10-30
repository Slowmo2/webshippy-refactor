<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Test\helper;

use App\Writer\WritableInterface;

final class Printable implements WritableInterface
{
    public function getLine(): array
    {
        return ['a', 'b'];
    }

    public static function getHeader(): array
    {
        return ['column_a', 'column_b'];
    }
}