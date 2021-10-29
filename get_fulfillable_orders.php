<?php

use App\Command\Command;

require_once './src/Command/Command.php';

try {
    $command = new Command(2);
    $stock = $command->getJsonParameter(1);
} catch (\Exception $exception) {
    echo $exception->getMessage();
    exit(1);
}

$orders = [];
$ordersH = [];

$row = 1;
if (($handle = fopen('orders.csv', 'r')) !== false) {
    while (($data = fgetcsv($handle)) !== false) {
        if ($row == 1) {
            $ordersH = $data;
        } else {
            $o = [];
            for ($i = 0; $i < count($ordersH); $i++) {
                $o[$ordersH[$i]] = $data[$i];
            }
            $orders[] = $o;
        }
        $row++;
    }
    fclose($handle);
}

usort($orders, function ($a, $b) {
    $pc = -1 * ($a['priority'] <=> $b['priority']);
    return $pc == 0 ? $a['created_at'] <=> $b['created_at'] : $pc;
});

foreach ($ordersH as $h) {
    echo str_pad($h, 20);
}
echo "\n";
foreach ($ordersH as $h) {
    echo str_repeat('=', 20);
}
echo "\n";
foreach ($orders as $item) {
    if ($stock->{$item['product_id']} >= $item['quantity']) {
        foreach ($ordersH as $h) {
            if ($h == 'priority') {
                if ($item['priority'] == 1) {
                    $text = 'low';
                } else {
                    if ($item['priority'] == 2) {
                        $text = 'medium';
                    } else {
                        $text = 'high';
                    }
                }
                echo str_pad($text, 20);
            } else {
                echo str_pad($item[$h], 20);
            }
        }
        echo "\n";
    }
}
