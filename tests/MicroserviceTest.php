<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Tests;

use App\FileReader\CSVFileReader;
use App\Microservice;
use App\Repository\OrderFileRepository;
use App\Sort\OrderPrioritySort;
use App\Writer\Printer;
use PHPUnit\Framework\TestCase;

require __DIR__.'/../autoload.php';

// Note: I wouldn't really call this a unit test, however what this tests is basically the use of all the things that
//       has already been tested. Also, I was given two inputs with two outputs as an example, why not include it in a test?

/**
 * @covers \App\Microservice
 * @covers \App\Repository\AbstractOrderRepository
 * @covers \App\Repository\OrderFileRepository
 *
 * @uses \App\Sort\OrderPrioritySort
 * @uses \App\FileReader\CSVFileReader
 * @uses \App\Model\Order
 * @uses \App\Writer\Printer
 */
class MicroserviceTest extends TestCase
{
    private const FILENAME =  __DIR__.'/helper/microservice_happy_path.csv';
    private const CASES = [
        [
            'stock' => [
                1 => 8,
                2 => 4,
                3 => 5,
            ],
            'output' =>
                "product_id          quantity            priority            created_at          \n".
                "================================================================================\n".
                "3                   5                   high                2021-03-23 05:01:29 \n".
                "1                   2                   high                2021-03-25 14:51:47 \n".
                "2                   1                   medium              2021-03-21 14:00:26 \n".
                "1                   8                   medium              2021-03-22 09:58:09 \n".
                "3                   1                   medium              2021-03-22 12:31:54 \n".
                "1                   6                   low                 2021-03-21 06:17:20 \n".
                "2                   4                   low                 2021-03-22 17:41:32 \n".
                "2                   2                   low                 2021-03-24 11:02:06 \n".
                "3                   2                   low                 2021-03-24 12:39:58 \n".
                "1                   1                   low                 2021-03-25 19:08:22 \n",
        ],
        [
            'stock' => [
                1 => 2,
                2 => 3,
                3 => 1,
            ],
            'output' =>
                "product_id          quantity            priority            created_at          \n".
                "================================================================================\n".
                "1                   2                   high                2021-03-25 14:51:47 \n".
                "2                   1                   medium              2021-03-21 14:00:26 \n".
                "3                   1                   medium              2021-03-22 12:31:54 \n".
                "2                   2                   low                 2021-03-24 11:02:06 \n".
                "1                   1                   low                 2021-03-25 19:08:22 \n",
        ],
    ];

    private Microservice $microservice;

    protected function setUp(): void
    {
        $this->microservice = new Microservice(new OrderFileRepository(new CSVFileReader(), self::FILENAME, new OrderPrioritySort()), new Printer());
    }

    public function testMicroserviceHappyPathOne(): void
    {
        $case = self::CASES[0];
        try {
            $this->microservice->run($case['stock']);
        } catch (\Throwable $exception) {
            $this->fail('Error during running the micro service');
        }

        $this->expectOutputString($case['output']);
    }

    public function testMicroserviceHappyPathTwo(): void
    {
        $case = self::CASES[1];
        try {
            $this->microservice->run($case['stock']);
        } catch (\Throwable $exception) {
            $this->fail('Error during running the micro service');
        }

        $this->expectOutputString($case['output']);
    }
}