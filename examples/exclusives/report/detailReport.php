<?php

$autoload = realpath(__DIR__ . "/../../../vendor/autoload.php");
if (!file_exists($autoload)) {
    die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiPayException;
use Efi\EfiPay;

$options = __DIR__ . "/../../credentials/options.php";
if (!file_exists($options)) {
	die("Options file not found or on path <code>$options</code>.");
}
require $options;

$params = [
	"id" => "e1e9721e-c386-4e9e-9391-e50fbd0d1117"
];

try {
	$api = EfiPay::getInstance($options);
	$response = $api->detailReport($params);

	if (is_array($response)) {
		print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	} else {
		$output = fopen('php://output', 'w');
		fputs($output, $response);

		// Tell the browser it's going to be a csv file and download it
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=report_' . $params['id'] . '.csv');
	}
} catch (EfiPayException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
} catch (Exception $e) {
	print_r($e->getMessage());
}
