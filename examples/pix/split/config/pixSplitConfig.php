<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/split-de-pagamento-pix#configuração-de-um-split-de-pagamento-sem-passar-id
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

$body = [
	"descricao" => "Payment split - Plan 1",
	"lancamento" => [
		"imediato" => true
	],
	"split" => [
		"divisaoTarifa" => "assumir_total", //"assumir_total", "proporcional"
		"minhaParte" => [
			"tipo" => "porcentagem",
			"valor" => "80.00"
		],
		"repasses" => [
			[
				"tipo" => "porcentagem",
				"valor" => "12.00",
				"favorecido" => [
					"cpf" => "11111111111",
					"conta" => "1234567"
				]
			],
			[
				"tipo" => "porcentagem",
				"valor" => "8.00",
				"favorecido" => [
					"cpf" => "22222222222",
					"conta" => "7654321"
				]
			]
		]
	]
];

try {
	$api = new EfiPay($options);
	$response = $api->pixSplitConfig($params = [], $body);

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
