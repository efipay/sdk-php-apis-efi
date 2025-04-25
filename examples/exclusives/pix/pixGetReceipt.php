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
    "e2eid" => "E0000000000000000000000000000"
    // "txid" => "0000000000000000000000000000000"
    // "idEnvio" => "0000000000000000000000000000000"
    // "rtrId" => "D0000000000000000000000000000"
];

try {
    $api = new EfiPay($options);
    $response = $api->pixGetReceipt($params);

    if (isset($options["responseHeaders"]) && $options["responseHeaders"] && is_array($response->body)) {
        print_r("<pre>" . json_encode($response->body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
        print_r("<pre>" . json_encode($response->headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
    } else if (is_array($response)) {
        print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
    } else {
        // Pegar o nome do arquivo do cabeçalho Content-Disposition
        $filename = 'comprovante.pdf'; // valor padrão
        if (isset($response->headers['Content-Disposition'])) {
            preg_match('/filename="([^"]+)"/', $response->headers['Content-Disposition'][0], $matches);
            if (isset($matches[1])) {
                $filename = $matches[1];
            }
        }

        $pdf = ($response->body) ? $response->body : $response;

        // Enviar cabeçalhos para o navegador
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($pdf));

        // Enviar o conteúdo do PDF
        echo $pdf;
        exit;
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
