<?php

return [
    "URL" => [
        "production" => "https://openfinance.api.efipay.com.br",
        "sandbox" => "https://openfinance-h.api.efipay.com.br"
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/oauth/token",
            "method" => "post"
        ],
        "ofConfigUpdate" => [
            "route" => "/v1/config",
            "method" => "put",
            "scope" => "gn.opb.config.write"
        ],
        "ofConfigDetail" => [
            "route" => "/v1/config",
            "method" => "get",
            "scope" => "gn.opb.config.read"
        ],
        "ofListParticipants" => [
            "route" => "/v1/participantes",
            "method" => "get",
            "scope" => "gn.opb.participants.read"
        ],
        "ofStartPixPayment" => [
            "route" => "/v1/pagamentos/pix",
            "method" => "post",
            "scope" => "gn.opb.payment.pix.send"
        ],
        "ofListPixPayment" => [
            "route" => "/v1/pagamentos/pix",
            "method" => "get",
            "scope" => "gn.opb.payment.pix.read"
        ],
        "ofDevolutionPix" => [
            "route" => "/v1/pagamentos/pix/:identificadorPagamento/devolver",
            "method" => "post",
            "scope" => "gn.opb.payment.pix.refund"
        ],
        "ofCancelSchedulePix" => [
            "route" => "/v1/pagamentos/pix/:identificadorPagamento/cancelar",
            "method" => "patch",
            "scope" => "gn.opb.payment.pix.cancel"
        ]
    ]
];
