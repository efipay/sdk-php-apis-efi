<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/cartao#2-associar-à-forma-de-pagamento-via-cartão
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

$paymentToken = "insert_here_the_payment_token_referring_to_card_data";

$customer = [
	"name" => "Gorbadoc Oldbuck",
	"cpf" => "04267484171",
	"phone_number" => "5144916523",
	"email" => "oldbuck@server.com.br",
	"birth" => "1990-01-15"
];

$billingAddress = [
	"street" => "Av JK",
	"number" => 909,
	"neighborhood" => "Bauxita",
	"zipcode" => "35400000",
	"city" => "Ouro Preto",
	"state" => "MG",
];

$body = [
	"payment" => [
		"credit_card" => [
			"installments" => 1,
			"billing_address" => $billingAddress,
			"payment_token" => $paymentToken,
			"customer" => $customer
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->definePayMethod($params, $body);

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
