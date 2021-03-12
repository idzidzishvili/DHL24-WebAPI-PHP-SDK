<?php

require_once '../vendor/autoload.php';

require_once 'ExamplesConfig.php';

use Alexcherniatin\DHL\DHL24;
use Alexcherniatin\DHL\Utils;
use Alexcherniatin\DHL\Structures\ItemToPrint;

$dhl = new DHL24(
    ExamplesConfig::LOGIN,
    ExamplesConfig::PASSWORD,
    ExamplesConfig::ACCOUNT_NUMBER,
    ExamplesConfig::SANDBOX
);

echo '<pre>';

try {

    $itemsToPrint = [];

    $itemsToPrint[] = (new ItemToPrint())
        ->setLabelType(ItemToPrint::LABEL_TYPE_LP)
        ->setShipmentId('90011967121')
        ->structure();

    $itemsToPrint[] = (new ItemToPrint())
        ->setLabelType(ItemToPrint::LABEL_TYPE_LBLP)
        ->setShipmentId('90011967121')
        ->structure();

    $result = $dhl->getLabels($itemsToPrint);

    $savedLabelsName = Utils::saveLabels($result, 'labels/');

    print_r($result);

    print_r($savedLabelsName);

} catch (\Throwable $th) {
    echo $th->getMessage();
}

