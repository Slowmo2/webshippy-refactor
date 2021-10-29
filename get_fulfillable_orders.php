<?php

use App\FileReader\CSVFileReader;
use App\OrderRepository;
use App\Parameter\ParameterParser;
use App\Microservice;
use App\Sort\OrderPrioritySort;

require_once './autoload.php';

const INPUT_PARAMETER_TYPES = [ParameterParser::TYPE_JSON];
const ORDERS_SOURCE_FILE = 'orders.csv';

try {

    $parameters = new ParameterParser(INPUT_PARAMETER_TYPES);
    $stockInfo = $parameters->getParameter(0);

    $service = new Microservice(new OrderRepository(new CSVFileReader(), new OrderPrioritySort()));
    $service->run($stockInfo, ORDERS_SOURCE_FILE);

} catch (\Exception $exception) {
    echo $exception->getMessage();
    exit(1);
}
