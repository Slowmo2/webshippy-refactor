<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace App\FileReader;

final class CSVFileReader implements FileReaderInterface
{
    public function read(string $fileName): array
    {
        $handle = \fopen($fileName, 'r');
        if ($handle === false) {
            return []; // On failure fopen usually emits a warning
        }

        $data = [];
        if (($indexes = \fgetcsv($handle)) !== false) {
            while (($line = \fgetcsv($handle)) !== false) {
                $data[] = \array_combine($indexes, $line);
            }
        }

        \fclose($handle);

        return $data;
    }
}