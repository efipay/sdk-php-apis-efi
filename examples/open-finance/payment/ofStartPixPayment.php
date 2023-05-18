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

$options["headers"] = [
	"x-idempotency-key" => "dt9BHlyzrb5jrFNAdfEDVpHgiOmDbVqVxd"
];

$body = [
	"pagador" => [
		"idParticipante" => "00000000-0000-0000-0000-000000000000",
		"cpf" => "12345678909",
	],
	"favorecido" => [
		"contaBanco" => [
			"codigoBanco" => "364",
			"agencia" => "0001",
			"documento" => "11122233344",
			"nome" => "Gorbadoc Oldbuck",
			"conta" => "000000",
			"tipoConta" => "CACC"
		]
	],
	"valor" => "0.01",
	"infoPagador" => "Order 00001",
	"idProprio" => "Order_00001"
];

try {
	$api = EfiPay::getInstance($options);
	$response = $api->ofStartPixPayment($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiPayException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
