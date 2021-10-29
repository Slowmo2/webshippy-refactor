<?php

namespace App;

interface FileReaderInterface
{
    public function read(string $fileName): array;
}