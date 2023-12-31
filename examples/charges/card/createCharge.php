<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/cartao#1-criar-transação
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

$items = [
	[
		"name" => "Product 1",
		"amount" => 1,
		"value" => 1000
	],
	[
		"name" => "Product 2",
		"amount" => 2,
		"value" => 2000
	]
];

$shippings = [ // Optional
	[
		"name" => "Shipping to City",
		"value" => 2000
	]
];

$metadata = [
	"custom_id" => "Order_00001",
	"notification_url" => "https://your-domain.com.br/notification/"
];

$body = [
	"items" => $items,
	"shippings" => $shippings,
	"metadata" => $metadata
];

try {
	$api = new EfiPay($options);
	$response = $api->createCharge($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
