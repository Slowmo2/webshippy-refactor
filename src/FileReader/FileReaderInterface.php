<?php

namespace App\FileReader;

interface FileReaderInterface
{
    public function read(string $fileName): array;
}