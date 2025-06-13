<?php

/**
 * Detailed endpoint documentation
 *https://dev.efipay.com.br/docs/api-pix/payload-locations#consultar-locations-de-recorrência-de-pix-automático-cadastradas
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
	"inicio" => "2025-01-22T00:00:00Z",
	"fim" => "2025-12-31T23:59:59Z",
	// "idRecPresente" => "000000000000001",
	// "convenio" => "000000000000001",
	// "paginacao.paginaAtual" => 1,
	// "paginacao.itensPorPagina" => 50
];

try {
	$api = new EfiPay($options);
	$response = $api->pixListLocationRecurrenceAutomatic($params);

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
