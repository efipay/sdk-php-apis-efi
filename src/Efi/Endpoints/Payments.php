<?php

return [
    "URL" => [
        "production" => "https://pagarcontas.api.efipay.com.br",
        "sandbox" => null
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/oauth/token",
            "method" => "POST"
        ],
        "payDetailBarCode" => [
            "route" => "/v1/codBarras/:codBarras",
            "method" => "GET",
            "scope" => "gn.barcode.read"
        ],
        "payRequestBarCode" => [
            "route" => "/v1/codBarras/:codBarras",
            "method" => "POST",
            "scope" => "gn.barcode.pay.write"
        ],
        "payDetailPayment" => [
            "route" => "/v1/:idPagamento",
            "method" => "GET",
            "scope" => "gn.barcode.read"
        ],
        "payListPayments" => [
            "route" => "/v1/resumo",
            "method" => "GET",
            "scope" => "gn.barcode.read"
        ],
        "payConfigWebhook" => [
            "route" => "/v1/webhook",
            "method" => "PUT",
            "scope" => "payment.webhook.write"
        ],
        "payDeleteWebhook" => [
            "route" => "/v1/webhook",
            "method" => "DELETE",
            "scope" => "payment.webhook.write"
        ],
        "payListWebhook" => [
            "route" => "/v1/webhook",
            "method" => "GET",
            "scope" => "payment.webhook.read"
        ]
    ]
];
