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
	"id" => 0
];

$body = [
	"title" => "Balance sheet demonstrative",
	"body" =>
	[
		0 =>
		[
			"header" => "Consumption  de Consumo",
			"tables" =>
			[
				0 =>
				[
					"rows" =>
					[
						0 =>
						[
							0 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "bold",
								"text" => "Expense example",
								"colspan" => 2,
							],
							1 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "bold",
								"text" => "Total posted",
								"colspan" => 2,
							],
						],
						1 =>
						[
							0 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "normal",
								"text" => "Installation",
								"colspan" => 2,
							],
							1 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "normal",
								"text" => "R$ 100,00",
								"colspan" => 2,
							],
						],
					],
				],
			],
		],
		1 =>
		[
			"header" => "Balance Sheet",
			"tables" =>
			[
				0 =>
				[
					"rows" =>
					[
						0 =>
						[
							0 =>
							[
								"align" => "left",
								"color" => "#000000",
								"style" => "normal",
								"text" => "Check in the Efí documentation all the possible configurations of a balance sheet.",
								"colspan" => 4,
							],
						],
					],
				],
			],
		],
	],
];

try {
	$api = new EfiPay($options);
	$response = $api->defineBalanceSheetBillet($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiPayException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
