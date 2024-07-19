<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/endpoints-exclusivos-efi#requisitar-extrato-conciliação
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
	"dataMovimento" => "2024-12-10",
	"tipoRegistros" => [
		"pixRecebido" => true,
		"pixEnviadoChave" => true,
		"pixEnviadoDadosBancarios" => true,
		"estornoPixEnviado" => true,
		"pixDevolucaoEnviada" => true,
		"pixDevolucaoRecebida" => true,
		"tarifaPixEnviado" => true,
		"tarifaPixRecebido" => true,
		"estornoTarifaPixEnviado" => true,
		"saldoDiaAnterior" => true,
		"saldoDia" => true,
		"transferenciaEnviada" => true,
		"transferenciaRecebida" => true,
		"estornoTransferenciaEnviada" => true,
		"tarifaTransferenciaEnviada" => true,
		"estornoTarifaTransferenciaEnviada" => true,
		"estornoTarifaPixRecebido" => true
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->createReport($params = [], $body);

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
