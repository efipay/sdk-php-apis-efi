<?php

return [
    "URL" => [
        "production" => "https://abrircontas.api.efipay.com.br",
        "sandbox" => "https://abrircontas-h.api.efipay.com.br"
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/oauth/token",
            "method" => "POST"
        ],
        "createAccount" => [
            "route" => "/v1/conta-simplificada",
            "method" => "POST",
            "scope" => "gn.registration.write"
        ],
        "getAccountCredentials" => [
            "route" => "/v1/conta-simplificada/:idContaSimplificada/credenciais",
            "method" => "GET",
            "scope" => "gn.registration.read"
        ],
        "createAccountCertificate" => [
            "route" => "/v1/conta-simplificada/:idContaSimplificada/certificado",
            "method" => "POST",
            "scope" => "gn.registration.read"
        ],
        "accountConfigWebhook" => [
            "route" => "/v1/webhook",
            "method" => "POST",
            "scope" => "gn.registration.webhook.write"
        ],
        "accountListWebhook" => [
            "route" => "/v1/webhooks",
            "method" => "GET",
            "scope" => "gn.registration.webhook.read"
        ],
        "accountDetailWebhook" => [
            "route" => "/v1/webhook/:identificadorWebhook",
            "method" => "GET",
            "scope" => "gn.registration.webhook.read"
        ],
        "accountDeleteWebhook" => [
            "route" => "/v1/webhook/:identificadorWebhook",
            "method" => "DELETE",
            "scope" => "gn.registration.webhook.write"
        ]
    ]
];
