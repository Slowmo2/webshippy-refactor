<?php

use App\Parameter\ParameterParser;
use App\Microservice;

require_once './src/Parameter/ParameterParser.php';
require_once './src/Microservice.php';

const INPUT_PARAMETER_TYPES = [ParameterParser::TYPE_JSON];

try {
    $parameters = new ParameterParser(INPUT_PARAMETER_TYPES);
    $stock = $parameters->getParameter(0);

    $service = new Microservice();
    $service->run($stock);
} catch (\Exception $exception) {
    echo $exception->getMessage();
    exit(1);
}
