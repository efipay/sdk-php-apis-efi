<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/endpoints-exclusivos-efi#solicitar-download-extrato-conciliação
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
	"id" => "00000000-0000-0000-0000-000000000000"
];

try {
	$api = new EfiPay($options);
	$response = $api->detailReport($params);

	if (isset($options["responseHeaders"]) && $options["responseHeaders"] && is_array($response->body)) {
		echo "<pre>" . json_encode($response->body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
		echo "<pre>" . json_encode($response->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
	} else if (is_array($response)) {
		echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
	} else {
		// CSV output - Disable debug mode to download the file
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=Report_" . $params['id'] . ".csv");

		$output = fopen("php://output", "w");
		fputs($output, "\xEF\xBB\xBF");

		if (extension_loaded('mbstring')) {
			$responseData = isset($response->body) ? $response->body : $response;
			fputs($output, mb_convert_encoding($responseData, 'UTF-8'));
		} else {
			throw new Exception("A extensão 'mbstring' não está habilitada. Por favor, habilite-a no PHP para continuar.");
		}
		fclose($output);
	}
} catch (EfiException $e) {
	echo $e->code . "<br>";
	echo $e->error . "<br>";
	echo $e->errorDescription . "<br>";
	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		echo "<pre>" . json_encode($e->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
	}
} catch (Exception $e) {
	echo $e->getMessage();
}
