<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-com-vencimento#criaralterar-lote-de-cobranças-com-vencimento
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

$params = [
	"id" => 1 // integer($int64)
];

$body = [
	"descricao" => "Cobranças dos alunos do turno vespertino",
	"cobsv" => [
		[
			"calendario" => [
				"dataDeVencimento" => "2023-12-16",
				"validadeAposVencimento" => 5
			],
			"txid" => "00000000000000000000000000000000000",
			"devedor" => [
				"cpf" => "08577095428",
				"nome" => "João Souza"
			],
			"valor" => [
				"original" => "0.01"
			],
			"chave" => "00000000-0000-0000-0000-000000000000",
			"solicitacaoPagador" => "Informar matrícula"
		],
		[
			"calendario" => [
				"dataDeVencimento" => "2023-12-17",
				"validadeAposVencimento" => 6
			],
			"txid" => "00000000000000000000000000000000001",
			"devedor" => [
				"cpf" => "15311295449",
				"nome" => "Manoel Silva"
			],
			"valor" => [
				"original" => "0.02"
			],
			"chave" => "00000000-0000-0000-0000-000000000000",
			"solicitacaoPagador" => "Informar matrícula"
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->pixCreateDueChargeBatch($params, $body);

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
