<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pagamento-de-contas/pagamentos#consultar-solicitação-de-pagamento
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
	"idPagamento" => 0,
	// "status" => "REALIZADO" // EM_PROCESSAMENTO, AGENDADO, LIQUIDADO, CANCELADO, NAO_REALIZADO 
];

try {
	$api = new EfiPay($options);
	$response = $api->payDetailPayment($params);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
