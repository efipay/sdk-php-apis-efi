<?php

if (file_exists($autoload = realpath(__DIR__ . "/../../../vendor/autoload.php"))) {
	require_once $autoload;
} else {
	print_r("Autoload not found or on path <code>$autoload</code>");
}

use Efi\Exception\EfiPayException;
use Efi\EfiPay;

if (file_exists($options = realpath(__DIR__ . "/../../credentials/options.php"))) {
	require_once $options;
}

$params = [
	"token" => "00000000-0000-0000-0000-000000000000"
];

try {
	$api = new EfiPay($options);
	$response = $api->getNotification($params);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
	header("HTTP/1.1 200");
} catch (EfiPayException $e) {
	print_r($e->code);
	print_r($e->error);
	print_r($e->errorDescription);
	header("HTTP/1.1 400");
} catch (Exception $e) {
	print_r($e->getMessage());
	header("HTTP/1.1 401");
}
