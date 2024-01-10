<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-com-vencimento#revisar-cobranças-específicas-de-um-lote
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
	"id" => 1 // integer($int64)
];

$body = [
	"cobsv" => [
		[
			"calendario" => [
				"dataDeVencimento" => "2023-12-18",
			],
			"txid" => "00000000000000000000000000000000000",
			"valor" => [
				"original" => "0.02"
			]
		],
		[
			"calendario" => [
				"dataDeVencimento" => "2023-12-19",
			],
			"txid" => "00000000000000000000000000000000001",
			"valor" => [
				"original" => "0.03"
			]
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->pixUpdateDueChargeBatch($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
