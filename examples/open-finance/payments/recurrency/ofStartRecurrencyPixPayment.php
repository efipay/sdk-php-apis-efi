<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-open-finance/pagamentos-recorrentes#solicitar-iniciação-de-pix-recorrente-via-open-finance
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

$options["headers"] = [
	"x-idempotency-key" => "00000000000000000000000000000006" // Random identifier | minLength: 36 maxLength: 72
];

$body = [
	"pagador" => [
		"idParticipante" => "ebbed125-5cd7-42e3-965d-2e7af8e3b7ae",
		"cpf" => "11789337682",
		// "cnpj" => "12345678901234"
	],
	"favorecido" => [
		"contaBanco" => [
			"codigoBanco" => "364",
			"agencia" => "0001",
			"documento" => "11789337682",
			"nome" => "Guilherme Soares Cota",
			"conta" => "2712075",
			"tipoConta" => "CACC"
		]
	],
	"pagamento" => [
		"valor" => "0.01",
		"infoPagador" => "Order 00001",
		"idProprio" => "Client00001Order00001",
		"recorrencia" => [
			"tipo" => "mensal", // "diaria ", "semanal", "mensal", "personalizada"
			"dataInicio" => "2025-01-01", // Field is mandatory for recurring payments of daily, weekly and monthly type
			"quantidade" => 12, // Field is mandatory for recurring payments of daily, weekly and monthly type
			"diaDoMes" => 10, // Field is mandatory for recurring payments of monthly type
			// "diaDaSemana" => "SEGUNDA_FEIRA", // Field is mandatory for recurring payments of weekly type
			// "datas" => [ // Field is mandatory for custom type payments
			// 	[
			// 		"2024-08-01",
			// 		"2024-08-08",
			// 		"2024-08-15"
			// 	]
			// ],
			"descricao" => "Streaming subscription"
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->ofStartRecurrencyPixPayment($params = [], $body);

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
