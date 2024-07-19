<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-imediatas#criar-cobrança-imediata-sem-txid
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

$body = [
	"calendario" => [
		"expiracao" => 3600 // Charge lifetime, specified in seconds from creation date
	],
	"devedor" => [
		"cpf" => "12345678909",
		"nome" => "Francisco da Silva"
	],
	"valor" => [
		"original" => "0.01"
	],
	"chave" => "00000000-0000-0000-0000-000000000000", // Pix key registered in the authenticated Efí account
	"solicitacaoPagador" => "Enter the order number or identifier.",
	"infoAdicionais" => [
		[
			"nome" => "Field 1",
			"valor" => "Additional information1"
		],
		[
			"nome" => "Field 2",
			"valor" => "Additional information2"
		]
	]
];

try {
	$api = new EfiPay($options);
	$responsePix = $api->pixCreateImmediateCharge($params = [], $body); // Using this function the txid will be generated automatically by Efí API

	$responseBodyPix = (isset($options["responseHeaders"]) && $options["responseHeaders"]) ? $responsePix->body : $responsePix;

	if ($responseBodyPix["txid"]) {
		$params = [
			"id" => $responseBodyPix["loc"]["id"]
		];

		try {
			$responseQrcode = $api->pixGenerateQRCode($params);

			$responseBodyQrcode = (isset($options["responseHeaders"]) && $options["responseHeaders"]) ? $responseQrcode->body : $responseQrcode;

			echo "<b>Detalhes da cobrança:</b>";
			echo "<pre>" . json_encode($responseBodyPix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

			echo "<b>QR Code:</b>";
			echo "<pre>" . json_encode($responseBodyQrcode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

			echo "<b>Imagem:</b><br>";
			echo "<img src='" . $responseBodyQrcode["imagemQrcode"] . "' />";
		} catch (EfiException $e) {
			print_r($e->code . "<br>");
			print_r($e->error . "<br>");
			print_r($e->errorDescription . "<br>");
			if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
				print_r("<pre>" . json_encode($e->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
			}
		} catch (Exception $e) {
			print_r($e->getMessage());
		}
	} else {
		echo "<pre>" . json_encode($responseBodyPix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
	}
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		print_r("<pre>" . json_encode($e->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	}
} catch (Exception $e) {
	print_r($e->getMessage());
}
