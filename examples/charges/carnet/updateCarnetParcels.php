<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/carne#alterar-vencimento-de-parcelas-de-um-carnê
 */

$autoload = realpath(__DIR__ . "/../../../vendor/autoload.php");
if (!file_exists($autoload)) {
	die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$optionsFile = __DIR__ . "/../../credentials/options.php";
if (!file_exists($optionsFile)) {
	die("Options file not found or on path <code>$options</code>.");
}
$options = include $optionsFile;

$params = [
	"id" => 0
];

$body = [
	"parcels" => [
		[
			"parcel" => 2,
			"expire_at" => "2025-02-28"
		],
		[
			"parcel" => 3,
			"expire_at" => "2025-03-31"
		],
		[
			"parcel" => 4,
			"expire_at" => "2025-04-30"
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->updateCarnetParcels($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
