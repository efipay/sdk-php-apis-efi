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

    print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
    print_r($e->code . "<br>");
    print_r($e->error . "<br>");
    print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
    print_r($e->getMessage());
}
