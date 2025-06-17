<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/pix-automatico#criar-recorrência-de-pix-automático
 */

$autoload = realpath(__DIR__ . "/../../../../vendor/autoload.php");
if (!file_exists($autoload)) {
	die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$optionsFile = __DIR__ . "/../../../credentials/options.php";
if (!file_exists($optionsFile)) {
	die("Options file not found or on path <code>$options</code>.");
}
$options = include $optionsFile;

$body = [
	"vinculo" => [
		"contrato" => "63100862",
		"devedor" => [
			"cpf" => "11122233344",
			// "cnpj" => "11122233344444",
			"nome" => "Gorbadoc Oldbuck"
		],
		"objeto" => "Streamming"
	],
	"calendario" => [
		"dataInicial" => "2026-01-01",
		"dataFinal" => "2027-12-31", 
		"periodicidade" => "MENSAL" // SEMANAL/MENSAL/TRIMESTRAL/SEMESTRAL/ANUAL
	],
	"valor" => [
		"valorRec" => "35.00",
		// "valorMinimoRecebedor" => "30.00"
	],
	"politicaRetentativa" => "NAO_PERMITE", // PERMITE_3R_7D
	"loc" => 1,
	"ativacao" => [
		"dadosJornada" => [
			"txid" => "33beb661beda44a8928fef47dbeb2dc5"
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->pixCreateRecurrenceAutomatic($params = [], $body);

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
