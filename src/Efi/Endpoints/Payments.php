<?php

return [
    "URL" => [
        "production" => "https://pagarcontas.api.efipay.com.br",
        "sandbox" => null
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/oauth/token",
            "method" => "post"
        ],
        "payDetailBarCode" => [
            "route" => "/v1/codBarras/:codBarras",
            "method" => "get",
            "scope" => "gn.barcode.read"
        ],
        "payRequestBarCode" => [
            "route" => "/v1/codBarras/:codBarras",
            "method" => "post",
            "scope" => "gn.barcode.pay.write"
        ],
        "payDetailPayment" => [
            "route" => "/v1/:idPagamento",
            "method" => "get",
            "scope" => "gn.barcode.read"
        ],
        "payListPayments" => [
            "route" => "/v1/resumo",
            "method" => "get",
            "scope" => "gn.barcode.read"
        ]
    ]
];
