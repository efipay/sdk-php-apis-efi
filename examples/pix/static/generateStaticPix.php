<?php
$autoload = realpath(__DIR__ . "/../../../vendor/autoload.php");
if (!file_exists($autoload)) {
    die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\EfiPay;
use Efi\Exception\EfiException;

$chargeData = [
    "chave" => "00000000-0000-0000-0000-000000000000",
    "nomeRecebedor" => "EFISA", // max 25 characters
    "cidade" => "SAOPAULO", // max 15 characters
    "valor" => "0.01", // Optional | If not defined, or if equal to "0.00", the payer will be able to choose the amount to pay | max 13 characters
    'txid' => '0000000000000000000000001', // Optional
    "descricao" => "Regarding_the_sale-0001 ", // Optional | max 99 characters
    "pagamentoUnico" => false, // Optional | Default = false 
    "cep" => "01001000", // Optional | Only numbers
];

try {
    $api = new EfiPay([]);
    $brCode = $api->createStaticPix($chargeData);

    echo "<h3>Pix Copia e Cola:</h3>";
    echo "<textarea rows='4' cols='100' readonly onclick='this.select();''>" . htmlspecialchars($brCode) . "</textarea>";

    // The API used in this example is not official from Efí, it is used only for demonstration purposes
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($brCode);

    echo "<h3>QR Code:</h3>";
    echo "<img src='" . $qrCodeUrl . "' alt='QR Code PIX' />";

} catch (EfiException $e) {
    print_r($e->code . "<br>");
    print_r($e->error . "<br>");
    print_r($e->errorDescription) . "<br>";
}