<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\FileReader;

interface FileReaderInterface
{
    public function read(string $fileName): array;
}