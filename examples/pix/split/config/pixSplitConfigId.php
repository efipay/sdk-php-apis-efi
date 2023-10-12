<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/split-de-pagamento-pix#configuração-de-um-split-de-pagamento-com-id
 */

$autoload = realpath(__DIR__ . "/../../../../vendor/autoload.php");
if (!file_exists($autoload)) {
    die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$options = __DIR__ . "/../../../credentials/options.php";
if (!file_exists($options)) {
	die("Options file not found or on path <code>$options</code>.");
}
require $options;

$params = [
	"id" => "splitConfigId0000000000000000001"
];

$body = [
	"descricao" => "Payment split - Plan 1",
	"lancamento" => [
		"imediato" => true
	],
	"split" => [
		"divisaoTarifa" => "assumir_total", //"assumir_total", "proporcional"
		"minhaParte" => [
			"tipo" => "porcentagem",
			"valor" => "78.00"
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
	$api = EfiPay::getInstance($options);
	$response = $api->pixSplitConfigId($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
