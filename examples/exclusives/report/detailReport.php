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

	if (is_array($response)) {
		print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	} else {
		$output = fopen("php://output", "w,ccs=UTF-8");
		fputs($output, "\xEF\xBB\xBF");
		fputs($output, mb_convert_encoding($response, 'UTF-8'));

		// Tell the browser it's going to be a csv file and download it
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=report_" . $params['id'] . ".csv");
	}
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
} catch (Exception $e) {
	print_r($e->getMessage());
}
