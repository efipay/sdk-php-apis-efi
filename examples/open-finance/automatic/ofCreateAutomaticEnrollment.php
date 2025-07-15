<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-open-finance/pagamentos-automaticos#solicitar-criação-de-uma-adesão-para-um-pagamento-automático
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

$options["headers"] = [
    "x-idempotency-key" => "00000000000000000000000000000000" // Random identifier | minLength: 36 maxLength: 72
];

$body = [
    "pagador" => [
        "nome" => "Gorbadoc Oldbuck",
        "cpf" => "11122233344",
        // "cnpj" => "11122233344455",
        "idParticipante" => "00000000-0000-0000-0000-000000000000"
    ],
    "favorecido" => [
        "contaBanco" => [
            "nome" => "Gorbadoc Oldbuck",
            "documento" => "11122233344",
            "codigoBanco" => "09089356",
            "agencia" => "0001",
            "conta" => "000000",
            "tipoConta" => "TRAN"
        ]
    ],
    "assinatura" => [
        "expiracao" => "2026-08-27",
        "descricao" => "Product consumption XYZ",
        "idProprio" => "000000000000001",
        "configuracao" => [
            "automatico" => [
                // "valorFixo" => "100.00",
                "valorMinimo" => "50.00",
                "valorMaximo" => "250.00",
                "intervalo" => "SEMANAL",
                "dataInicio" => "2025-07-10",
                "permiteRetentativa" => true,
                "primeiroPagamento" => [
                    "data" => "2025-06-10",
                    "valor" => "25.00",
                    "infoPagador" => "Enrollment"
                ]
            ]
        ]
    ]
];

try {
    $api = new EfiPay($options);
    $response = $api->ofCreateAutomaticEnrollment($params = [], $body);

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
