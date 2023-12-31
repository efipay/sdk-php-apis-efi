<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-open-finance/pagamentos#solicitar-iniciação-de-pix-via-open-finance
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

$options["headers"] = [
	"x-idempotency-key" => "00000000000000000000000000000000" // Random identifier
];

$body = [
	"pagador" => [
		"idParticipante" => "00000000-0000-0000-0000-000000000000",
		"cpf" => "12345678909",
	],
	"favorecido" => [
		"contaBanco" => [
			"codigoBanco" => "364",
			"agencia" => "0001",
			"documento" => "11122233344",
			"nome" => "Gorbadoc Oldbuck",
			"conta" => "000000",
			"tipoConta" => "CACC"
		]
	],
	"detalhes" => [
		"valor" => "0.01",
		"infoPagador" => "Order 00001",
		"idProprio" => "Client00001Order00001",
		"dataAgendamento" => "2024-12-20"
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->ofStartPixPayment($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
