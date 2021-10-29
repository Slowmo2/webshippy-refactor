<?php

namespace App;

final class CSVReader implements FileReaderInterface
{
    public function read(string $fileName): array
    {
        $handle = \fopen($fileName, 'r');
        if ($handle === false) {
            return [];
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