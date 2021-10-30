<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

require_once './src/FileReader/FileReaderInterface.php';
require_once './src/FileReader/CSVFileReader.php';
require_once './src/Writer/WritableInterface.php';
require_once './src/Model/Order.php';
require_once './src/Parameter/ParameterParser.php';
require_once './src/Sort/OrderSorterInterface.php';
require_once './src/Sort/OrderPrioritySort.php';
require_once './src/Microservice.php';
require_once './src/Repository/OrderRepositoryInterface.php';
require_once './src/Repository/AbstractOrderRepository.php';
require_once './src/Repository/OrderFileRepository.php';
require_once './src/Writer/WriterInterface.php';
require_once './src/Writer/Printer.php';