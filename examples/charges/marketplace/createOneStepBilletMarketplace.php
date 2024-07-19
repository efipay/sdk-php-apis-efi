<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/split-de-pagamento#criação-de-transação-split-de-pagamento-em-one-step-um-passo
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

$item_1 = [
	"name" => "Product 1",
	"amount" => 1,
	"value" => 1500,
	"marketplace" => [
		"mode" => 2, // "mode = 1", rate will be discounted from issuing account only. "mode = 2", rate will be discounted proportionally to the percentage defined for all accounts
		"repasses" => [
			[
				"payee_code" => "Enter_Destination_Account_Identifier_Here", // Efí account identifier (transfer 1)
				"percentage" => 2500 // transfer percentage (2500 = 25%)
			],
			[
				"payee_code" => "Enter_Destination_Account_Identifier_Here", // Efí account identifier (transfer 2)
				"percentage" => 1500 // transfer percentage	(1500 = 15%)
			]
		]
	]
];

$items = [
	$item_1
];

$shippings = [
	[
		"name" => "Shipping to City",
		"value" => 1200,
		"payee_code" => "Enter_Destination_Account_Identifier_Here", // Efí account identifier (transfer shipping)
	]
];

$metadata = [
	"custom_id" => "Order_0001",
	"notification_url" => "https://your-domain.com.br/notification/"
];

$customer = [
	"name" => "Gorbadoc Oldbuck",
	"cpf" => "94271564656",
	"phone_number" => "5144916523",
];

$discount = [
	"type" => "currency", // "currency", "percentage"
	"value" => 599
];

$conditional_discount = [
	"type" => "percentage", // "currency", "percentage"
	"value" => 500,
	"until_date" => "2024-12-10"
];

$configurations = [
	"fine" => 200,
	"interest" => 33
];

$bankingBillet = [
	"expire_at" => "2024-12-10",
	"message" => "This is a space\n of up to 80 characters\n to tell\n your client something",
	"customer" => $customer,
	"discount" => $discount,
	"conditional_discount" => $conditional_discount
];

$payment = [
	"banking_billet" => $bankingBillet
];

$body = [
	"items" => $items,
	"metadata" => $metadata,
	"shippings" => $shippings,
	"payment" => $payment
];

try {
	$api = new EfiPay($options);
	$response = $api->createOneStepCharge($params = [], $body);

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
