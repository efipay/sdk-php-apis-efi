<?php

$autoload = realpath(__DIR__ . "/../../../vendor/autoload.php");
if (!file_exists($autoload)) {
    die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiPayException;
use Efi\EfiPay;

$options = __DIR__ . "/../../credentials/options.php";
if (!file_exists($options)) {
	die("Options file not found or on path <code>$options</code>.");
}
require $options;

$params = [
	"id" => 293
];

try {
	$api = EfiPay::getInstance($options);
	$response = $api->pixGenerateQRCode($params);

	echo "Pix Copia e Cola, QR Code e link de visualização:<br>";
	echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

	echo "Imagem:<br />";
	echo "<img src='" . $response["imagemQrcode"] . "' />";
} catch (EfiPayException $e) {
	echo $e->code . "<br>";
	echo $e->error . "<br>";
	echo $e->errorDescription . "<br>";
} catch (Exception $e) {
	echo $e->getMessage();
}
