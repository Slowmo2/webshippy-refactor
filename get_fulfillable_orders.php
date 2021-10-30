<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

use App\FileReader\CSVFileReader;
use App\Parameter\ParameterParser;
use App\Microservice;
use App\Repository\OrderFileRepository;
use App\Sort\OrderPrioritySort;
use App\Writer\Printer;

require_once './autoload.php';

const INPUT_PARAMETER_TYPES = [ParameterParser::TYPE_JSON];
const ORDERS_SOURCE_FILE = 'orders.csv';

try {

    $parameters = new ParameterParser(INPUT_PARAMETER_TYPES);
    $stockInfo = $parameters->getParameter(0); // Due to the lack of extra data in the stock input it's best to leave it as an array

    $service = new Microservice(new OrderFileRepository(new CSVFileReader(), ORDERS_SOURCE_FILE, new OrderPrioritySort()), new Printer());
    $service->run($stockInfo);

} catch (\Exception $exception) {
    echo $exception->getMessage();
    exit(1);
}
