<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/gestao-de-pix#requisitar-envio-de-pix
 */

$autoload = realpath(__DIR__ . "/../../../vendor/autoload.php");
if (!file_exists($autoload)) {
	die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$options = __DIR__ . "/../../credentials/options.php";
if (!file_exists($options)) {
	die("Options file not found or on path <code>$options</code>.");
}
require $options;

$params = [
	"idEnvio" => "00000000000000000000000000000000000"
];

$body = [
	"valor" => "0.01",
	"pagador" => [
		"chave" => "00000000-0000-0000-0000-000000000000", // Pix key registered in the authenticated Efí account
		"infoPagador" => "Order payment"
	],
	"favorecido" => [
		"chave" => "Receiver_Pix_key" // Type key: random, email, phone, cpf or cnpj
	]
];

try {
	$api = EfiPay::getInstance($options);
	$response = $api->pixSend($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
