<?php

require_once '../vendor/autoload.php';

require_once 'ExamplesConfig.php';

use Alexcherniatin\DHL\DHL24;
use Alexcherniatin\DHL\Structures\Address;
use Alexcherniatin\DHL\Structures\PaymentData;
use Alexcherniatin\DHL\Structures\Piece;
use Alexcherniatin\DHL\Structures\ReceiverAddress;
use Alexcherniatin\DHL\Structures\ServiceDefinition;
use Alexcherniatin\DHL\Structures\ShipmentFullData;

$dhl = new DHL24(
    ExamplesConfig::LOGIN,
    ExamplesConfig::PASSWORD,
    ExamplesConfig::ACCOUNT_NUMBER,
    ExamplesConfig::SANDBOX
);

//Sender address
$addressStructure = (new Address())
    ->setName('Tester Senderowich')
    ->setPostalCode('01771')
    ->setCity('Warszawa')
    ->setStreet('Braci Załuskich')
    ->setHouseNumber('4a')
    ->setApartmentNumber('5')
    ->setContactPerson('Tester Senderowich')
    ->setContactPhone('777-888-999')
    ->setContactEmail('alex@vreego.pl')
    ->structure();

//Receiver address
$receiverAddressStructure = (new ReceiverAddress())
    ->setAddressType(ReceiverAddress::ADDRESS_TYPE_B)
    ->setCountry('PL')
    ->setName('Tester Receiverovich')
    ->setPostalCode('01-771')
    ->setCity('Warszawa')
    ->setStreet('Zgoda')
    ->setHouseNumber('4')
    ->setApartmentNumber('6')
    ->setContactPerson('Tester Receiverovich')
    ->setContactPhone('888-888-999')
    ->setContactEmail('alexcherniatin@gmail.com')
    ->structure();

//Package settings
$pieceStructure = (new Piece())
    ->setType(Piece::TYPE_PACKAGE)
    ->setWidth(25)
    ->setHeight(25)
    ->setLength(25)
    ->setWeight(3)
    ->setQuantity(1)
    ->setNonStandard(false)
    ->structure();

//Payment
$paymentStructure = (new PaymentData())
    ->setPaymentMethod(PaymentData::PAYMENT_METHOD_BANK_TRANSFER)
    ->setPayerType(PaymentData::PAYER_TYPE_SHIPPER)
    ->setAccountNumber(ExamplesConfig::ACCOUNT_NUMBER)
    ->structure();

//Service
$serviceDefinitionStructure = (new ServiceDefinition())
    ->setProduct(ServiceDefinition::PRODUCT_DOMESTIC_SHIPMENT)
    ->setInsurance(true)
    ->setInsuranceValue(200)
    ->structure();

//Group all data to shipment structure
$shipmentFullDataStructure = (new ShipmentFullData())
    ->setShipper($addressStructure)
    ->setReceiver($receiverAddressStructure)
    ->setPieceList(
        [
            $pieceStructure,
        ]
    )
    ->setPayment($paymentStructure)
    ->setService($serviceDefinitionStructure)
    ->setShipmentDate(\date(ShipmentFullData::DATE_FORMAT, \strtotime("2021-03-18")))
    ->setContent('Some content')
    ->setSkipRestrictionCheck(true)
    ->structure();

echo '<pre>';

try {

    $result = $dhl->createShipments($shipmentFullDataStructure);

    print_r($result);

} catch (\Throwable $th) {
    echo $th->getMessage();
}
