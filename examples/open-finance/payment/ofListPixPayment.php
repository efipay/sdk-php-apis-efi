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
	"inicio" => "2022-01-22",
	"fim" => "2024-12-31",
	// "quantidade" => 10,
	// "página" => 2,
	// "status" => "aceito" // "pendente", "agendado", "rejeitado", "aceito"
	//"identificador" => "urn:participant:00000000-0000-0000-0000-000000000000"
];

try {
	$api = EfiPay::getInstance($options);
	$response = $api->ofListPixPayment($params);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiPayException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
