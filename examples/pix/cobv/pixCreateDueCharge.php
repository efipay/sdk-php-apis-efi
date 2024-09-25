<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-com-vencimento#criar-cobrança-com-vencimento
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
	"txid" => "00000000000000000000000000000000000" //  Transaction unique identifier
];

$body = [
	"calendario" => [
		"dataDeVencimento" => "2024-12-31",
		"validadeAposVencimento" => 90
	],
	"devedor" => [
		"nome" => "Francisco da Silva",
		"cpf" => "12345678909",
		// "cnpj" => "12345678000100"
		// "email" => "emaildocliente@email.com.br",
		// "logradouro" => "Alameda Souza, Numero 80, Bairro Braz",
		// "cidade" => "Recife",
		// "uf" => "PE",
		// "cep" => "70011750"
	],
	"valor" => [
		"original" => "123.45",
		"multa" => [
			"modalidade" => 2,
			"valorPerc" => "2.00"
		],
		"juros" => [
			"modalidade" => 2,
			"valorPerc" => "0.30"
		],
		"desconto" => [
			"modalidade" => 1,
			"descontoDataFixa" => [
				[
					"data" => "2024-10-15",
					"valorPerc" => "30.00"
				],
				[
					"data" => "2024-11-15",
					"valorPerc" => "15.00"
				],
				[
					"data" => "2024-12-15",
					"valorPerc" => "5.00"
				]
			]
		]
	],
	"chave" => "00000000-0000-0000-0000-000000000000", // Pix key registered in the authenticated Efí account
	"solicitacaoPagador" => "Enter the order number or identifier.",
	"infoAdicionais" => [
		[
			"nome" => "Campo 1",
			"valor" => "Informação Adicional1"
		],
		[
			"nome" => "Campo 2",
			"valor" => "Informação Adicional2"
		]
	]
];

try {
	$api = new EfiPay($options);
	$responsePix = $api->pixCreateDueCharge($params, $body);

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
			print_r($e->errorDescription) . "<br>";
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
	print_r($e->errorDescription) . "<br>";
	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		print_r("<pre>" . json_encode($e->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	}
} catch (Exception $e) {
	print_r($e->getMessage());
}
