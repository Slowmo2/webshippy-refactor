<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Tests\FileReader;

use App\FileReader\CSVFileReader;
use PHPUnit\Framework\TestCase;

require __DIR__.'/../../autoload.php';

/**
 * @covers \App\FileReader\CSVFileReader
 */
class CSVFileReaderTest extends TestCase
{
    private const HAPPY_PATH = [
        'filename' => __DIR__.'/../helper/happy_path.csv',
        'data' => [
            [
                'product_id' => 1,
                'quantity' => 2,
                'priority' => 3,
                'created_at' => '2021-03-25 14:51:47',
            ],
            [
                'product_id' => 2,
                'quantity' => 1,
                'priority' => 2,
                'created_at' => '2021-03-21 14:00:26',
            ],
        ],
    ];

    private const EMPTY_BODY = [
        'filename' => __DIR__.'/../helper/empty_body.csv',
        'data' => [],
    ];

    private CSVFileReader $reader;

    protected function setUp(): void
    {
        $this->reader = new CSVFileReader();
    }

    public function testReadCSVFile(): void
    {
        try {
            $data = $this->reader->read(self::HAPPY_PATH['filename']);
        } catch (\Throwable $throwable) {
            $this->fail('Could not read file!');
        }

        $this->assertEquals(self::HAPPY_PATH['data'], $data);
    }

    public function testReadCSVFileWithEmptyBody(): void
    {
        try {
            $data = $this->reader->read(self::EMPTY_BODY['filename']);
        } catch (\Throwable $throwable) {
            $this->fail('Could not read file!');
        }

        $this->assertEquals(self::EMPTY_BODY['data'], $data);
    }

    public function testReadNonExistentCSVFile(): void
    {
        try {
            $this->reader->read('nonexistent_test_file.csv');
        } catch (\Throwable $throwable) {
            $this->assertEquals('fopen(nonexistent_test_file.csv): Failed to open stream: No such file or directory', $throwable->getMessage());
            return;
        }

        $this->fail('Unexpected error on non-existent file read!');
    }
}