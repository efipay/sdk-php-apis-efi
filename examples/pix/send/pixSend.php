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

//To enable the pix/send endpoint it is necessary to contact
//with Efí's Commercial team for a new contractual annex.

$params = [
	"idEnvio" => "0S000000000000000000000000000000000"
];

$body = [
	"valor" => "0.01",
	"pagador" => [
		"chave" => "00000000-0000-0000-0000-000000000000", // Pix key registered in the authenticated Efí account
		"infoPagador" => "order payment"
	],
	"favorecido" => [
		"chave" => ""
	]
];

try {
	$api = EfiPay::getInstance($options);
	$response = $api->pixSend($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiPayException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
