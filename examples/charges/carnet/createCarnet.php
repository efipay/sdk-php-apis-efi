<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/carne#criando-carnês
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

$customer = [
	"name" => "Gorbadoc Oldbuck",
	"cpf" => "94271564656",
	// "phone_number" => "5144916523",
	// "email" => "client_email@server.com.br",
	// "address" => [
	// 	"street" => "Avenida Juscelino Kubitschek",
	// 	"number" => "909",
	// 	"neighborhood" => "Bauxita",
	// 	"zipcode" => "35400000",
	// 	"city" => "Ouro Preto",
	// 	"complement" => "",
	// 	"state" => "MG"
	// ],
	// "juridical_person" => [
	// 	"corporate_name" => "Nome da razão social",
	// 	"cnpj" => "123456789000123"
	// ]
];

$configurations = [
	"fine" => 200,
	"interest" => 33
];

$discount = [
	"type" => 'currency',
	"value" => 599
];

$conditional_discount = [
	"type" => "percentage",
	"value" => 500,
	"until_date" => "2024-12-10"
];

$message = "This is a space\n of up to 80 characters\n to tell\n your client something";

$metadata = [
	"custom_id" => "Carnet 0001",
	"notification_url" => "https://your-domain.com.br/notification/"
];

$body = [
	"items" => $items,
	"customer" => $customer,
	"expire_at" => "2024-12-10",
	"message" => $message,
	"repeats" => 5,
	"split_items" => false,
	"configurations" => $configurations,
	"discount" => $discount,
	"conditional_discount" => $conditional_discount,
	"metadata" => $metadata
];

try {
	$api = new EfiPay($options);
	$response = $api->createCarnet($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
