<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-cobrancas/cartao
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

$paymentToken = "00000000000000000000000000000";  // Insert here the payment token obtained from the front-end

$tdsInfo = [
	"tds_identifier" => "00000000-0000-0000-0000-000000000000", // Identifier of the 3DS transaction in UUID format obtained from the front-end
	"challenge_callback_url" => "https://your-domain.com.br/payment-processing/" //URL of your application to which the customer will be redirected after completing the 3DS challenge
];

$items = [
	[
		"name" => "Product 1",
		"amount" => 1,
		"value" => 1000
	],
	[
		"name" => "Product 2",
		"amount" => 2,
		"value" => 2000
	]
];

$shippings = [
	[
		"name" => "Shipping to City",
		"value" => 1200
	]
];

$metadata = [
	"notification_url" => "https://webhook.site/00000000-0000-0000-0000-00000000"
];

$customer = [
	"name" => "Gorbadoc Oldbuck",
	"cpf" => "94271564656",
	"phone_number" => "5144916523",
	"email" => "oldbuck@server.com.br"
];

$billingAddress = [
	"street" => "Av JK",
	"number" => "909",
	"neighborhood" => "Bauxita",
	"zipcode" => "35400000",
	"city" => "Ouro Preto",
	"state" => "MG"
];

$discount = [
	"type" => "currency",
	"value" => 599
];

$body = [
	"items" => $items,
	"installments" => 1, // optional
	"shippings" => $shippings, // optional
	"metadata" => $metadata,
	"customer" => $customer,
	"discount" => $discount, // optional
	"billing_address" => $billingAddress, // optional
	"message" => "This is a space\n of up to 80 characters\n to tell\n your client something",
	"payment_token" => $paymentToken,
	"tds_info" => $tdsInfo,
];

try {
	$api = new EfiPay($options);
	$response = $api->createChargeCard($params = [], $body);

	$responseData = (isset($options["responseHeaders"]) && $options["responseHeaders"])
		? json_decode(json_encode($response->body), true)
		: json_decode(json_encode($response), true);

	echo "<h2>Log de Retorno da API:</h2>";

	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		echo "<pre>" . htmlspecialchars(json_encode($response->body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . "</pre>";
		echo "<pre>" . htmlspecialchars(json_encode($response->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . "</pre>";
	} else {
		echo "<pre>" . htmlspecialchars(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . "</pre>";
	}

	echo "<hr>";

	// Handling the 3DS Challenge
	if (isset($responseData['status']) && $responseData['status'] === 'waiting' && isset($responseData['tdsChallenge'])) {

		$tdsChallenge = $responseData['tdsChallenge'];

		/**
		 * =================================================================
		 * OPTION A: Using htmlTemplate (Easier and faster)
		 * =================================================================
		 * Uncomment the block below to use it. 
		 * The htmlTemplate is already a complete HTML document with a form and an auto-submit script.
		 */

		/*
		echo "<h3>Redirecionando para o ambiente seguro do banco...</h3>";
		echo $tdsChallenge['htmlTemplate'];
		exit; // Interrompe a execução para não carregar mais nada na página
		*/


		/**
		 * =================================================================
		 * OPTION B: Using formData (Full Frontend Control)
		 * =================================================================
		 * Example rendering the form from the structured data.
		 */
		$formData = $tdsChallenge['formData'];
		?>

		<!DOCTYPE html>
		<html lang="pt-BR">

		<head>
			<meta charset="UTF-8">
			<title>Autenticação 3D Secure</title>
			<style>
				body {
					font-family: sans-serif;
					background-color: #f4f4f9;
					padding: 20px;
				}

				.loader-container {
					max-width: 600px;
					margin: 50px auto;
					text-align: center;
					background: #fff;
					padding: 30px;
					border-radius: 8px;
					box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
				}

				.btn-submit {
					background-color: #f37021;
					color: white;
					padding: 10px 20px;
					border: none;
					border-radius: 4px;
					font-size: 16px;
					cursor: pointer;
					margin-top: 20px;
				}
			</style>
		</head>

		<body>
			<div class="loader-container">
				<h3>Aguarde, redirecionando para o seu banco...</h3>
				<p>Se você não for redirecionado automaticamente em alguns segundos, clique no botão abaixo.</p>

				<form id="custom_tds_form" method="<?= htmlspecialchars($formData['method']) ?>"
					action="<?= htmlspecialchars($formData['actionUrl']) ?>">

					<input type="hidden" name="creq" value="<?= htmlspecialchars($formData['creq']) ?>" />
					<input type="hidden" name="threeDSSessionData"
						value="<?= htmlspecialchars($formData['threeDSSessionData']) ?>" />

					<noscript>
						<button type="submit" class="btn-submit">Clique aqui para continuar</button>
					</noscript>
				</form>
			</div>

			<script>
				// Triggers the POST automatically as soon as the page renders.
				window.onload = function () {
					// To see the screen before the redirect during testing,
					// you can comment out the line below.
					document.getElementById('custom_tds_form').submit();
				};
			</script>
		</body>

		</html>

		<?php
		exit; // Ensures PHP execution ends after rendering the 3DS HTML
	}

} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
	if (isset($options["responseHeaders"]) && $options["responseHeaders"]) {
		print_r("<pre>" . htmlspecialchars(json_encode($e->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . "</pre>");
	}
} catch (Exception $e) {
	print_r($e->getMessage());
}