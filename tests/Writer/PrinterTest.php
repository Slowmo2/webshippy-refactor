<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Tests\Writer;

use App\Writer\Printer;
use PHPUnit\Framework\TestCase;
use Test\helper\Printable;

require __DIR__.'/../../autoload.php';
require __DIR__.'/../helper/Printable.php';

/**
 * @covers \App\Writer\Printer
 */
class PrinterTest extends TestCase
{
    private const OUTPUT_OF_TWO_PRINTABLE =
        "column_a            column_b            \n".
        "========================================\n".
        "a                   b                   \n".
        "a                   b                   \n"
    ;

    private Printer $printer;

    protected function setUp(): void
    {
        $this->printer = new Printer();
    }

    public function testPrintEmptyCollection(): void
    {
        $this->printer->writeItems([]);
        $this->expectOutputString('');
    }

    public function testPrintHappyPath(): void
    {
        $printableCollection = [
            new Printable(),
            new Printable(),
        ];

        $this->printer->writeItems($printableCollection);

        $this->expectOutputString(self::OUTPUT_OF_TWO_PRINTABLE);
    }
}