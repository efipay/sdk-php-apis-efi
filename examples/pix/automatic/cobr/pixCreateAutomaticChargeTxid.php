<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/pix-automatico#criar-cobrança-de-pix-automático-com-txid
 */

$autoload = realpath(__DIR__ . "/../../../../vendor/autoload.php");
if (!file_exists($autoload)) {
	die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$optionsFile = __DIR__ . "/../../../credentials/options.php";
if (!file_exists($optionsFile)) {
	die("Options file not found or on path <code>$options</code>.");
}
$options = include $optionsFile;

$params = [
	"txid" => "00000000000000000000000001"
];

$body = [
	"idRec" => "RR000000000000000000000000001",
	"infoAdicional" => "Streamming",
	"calendario" => [
		"dataDeVencimento" => "2026-12-31"
	],
	"valor" => [
		"original" => "0.01"
	],
	"ajusteDiaUtil" => true,
	"devedor" => [
		"cep" => "12345678",
		"cidade" => "City",
		"email" => "client.mail@server.com",
		"logradouro" => "Street name 123",
		"uf" => "MG"
	],
	"recebedor" => [
		"agencia" => "0001",
		"conta" => "00000",
		"tipoConta" => "CORRENTE"
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->pixCreateAutomaticChargeTxid($params, $body);

	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		print_r("<pre>" . json_encode($response->body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
		print_r("<pre>" . json_encode($response->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	} else {
		print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	}
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		print_r("<pre>" . json_encode($e->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	}
} catch (Exception $e) {
	print_r($e->getMessage());
}
