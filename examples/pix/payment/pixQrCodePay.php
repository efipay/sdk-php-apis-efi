<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/envio-pagamento-pix#pagar-qr-code-pix
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
    "idEnvio" => "00000000000000000000000000000000000"
];

$body = [
    "pagador" => [
        "chave" => "00000000-0000-0000-0000-000000000000",
        "infoPagador" => "Information about the payment"
    ],
    "pixCopiaECola" => "00020101021226850014BR.GOV.BCB.PIX2563qrcodespix.sejaefi.com.br/v2/000000000000000000000000000000000000000053039865802BR5905EFISA6008SAOPAULO62070503***63040E48"
];

try {
    $api = new EfiPay($options);
    $response = $api->pixQrCodePay($params, $body);

    print_r("<pre>" . json_encode($response->body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
    print_r("<pre>" . json_encode($response->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
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
