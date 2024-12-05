<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-open-finance/pagamentos-recorrentes#listar-pagamentos-recorrentes-por-um-determinado-período
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
	"inicio" => "2023-01-22",
	"fim" => "2024-12-31",
	// "quantidade" => 10,
	// "página" => 2,
	// "status" => "aceito" // "pendente", "agendado", "rejeitado", "expirado", "aceito", "cancelado"
	//"identificador" => "urn:participant:00000000-0000-0000-0000-000000000000"
];

try {
	$api = new EfiPay($options);
	$response = $api->ofListRecurrencyPixPayment($params);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
