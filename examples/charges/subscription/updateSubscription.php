<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/assinatura/#alterar-dados-de-uma-assinatura
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
    "payment_token" => "insert_here_the_payment_token_referring_to_card_data", // change the credit card for a subscription
    "plan_id" => 3,
    "customer" => [
        "email" => "gorbadoc.oldbuck@gmail.com",
        "phone_number" => "31123456789"
    ],
    "items" => [
        [
            "name" => "Product 1",
            "value" => 1000,
            "amount" => 1
        ]
    ],
    "shippings" => [
        [
            "name" => "frete",
            "value" => 1800
        ]
    ]
];

try {
    $api = new EfiPay($options);
    $response = $api->updateSubscription($params, $body);

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
