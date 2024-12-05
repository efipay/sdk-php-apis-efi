<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-open-finance/pagamentos-agendados#solicitar-iniciação-de-pix-agendado-via-open-finance
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
	"x-idempotency-key" => "00000000000000000000000000000008" // Random identifier | minLength: 36 maxLength: 72
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
			"conta" => "2712075",
			"tipoConta" => "CACC",
			"documento" => "11789337682",
			"nome" => "Guilherme Soares Cota"
		]
	],
	"pagamento" => [
		"valor" => "0.01",
		"dataAgendamento" => "2024-08-28",
		"infoPagador" => "Order 00001",
		"idProprio" => "Client00001Order00001"
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->ofStartSchedulePixPayment($params = [], $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
