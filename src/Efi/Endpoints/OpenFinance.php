<?php

return [
    "URL" => [
        "production" => "https://openfinance.api.efipay.com.br",
        "sandbox" => "https://openfinance-h.api.efipay.com.br"
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/oauth/token",
            "method" => "POST"
        ],
        "ofConfigUpdate" => [
            "route" => "/v1/config",
            "method" => "PUT",
            "scope" => "gn.opb.config.write"
        ],
        "ofConfigDetail" => [
            "route" => "/v1/config",
            "method" => "GET",
            "scope" => "gn.opb.config.read"
        ],
        "ofListParticipants" => [
            "route" => "/v1/participantes",
            "method" => "GET",
            "scope" => "gn.opb.participants.read"
        ],
        "ofStartPixPayment" => [
            "route" => "/v1/pagamentos/pix",
            "method" => "POST",
            "scope" => "gn.opb.payment.pix.send"
        ],
        "ofListPixPayment" => [
            "route" => "/v1/pagamentos/pix",
            "method" => "GET",
            "scope" => "gn.opb.payment.pix.read"
        ],
        "ofDevolutionPix" => [
            "route" => "/v1/pagamentos/pix/:identificadorPagamento/devolver",
            "method" => "POST",
            "scope" => "gn.opb.payment.pix.refund"
        ],
        "ofCancelSchedulePix" => [
            "route" => "/v1/pagamentos-agendados/pix/:identificadorPagamento/cancelar",
            "method" => "PATCH",
            "scope" => "gn.opb.payment.pix.cancel"
        ],
        "ofListSchedulePixPayment" => [
            "route" => "/v1/pagamentos-agendados/pix",
            "method" => "GET",
            "scope" => "gn.opb.payment.pix.read"
        ],
        "ofStartSchedulePixPayment" => [
            "route" => "/v1/pagamentos-agendados/pix",
            "method" => "POST",
            "scope" => "gn.opb.payment.pix.send"
        ],
        "ofDevolutionSchedulePix" => [
            "route" => "/v1/pagamentos-agendados/pix/:identificadorPagamento/devolver",
            "method" => "POST",
            "scope" => "gn.opb.payment.pix.refund"
        ],
        "ofStartRecurrencyPixPayment" => [
            "route" => "/v1/pagamentos-recorrentes/pix",
            "method" => "POST",
            "scope" => "gn.opb.payment.pix.send"
        ],
        "ofListRecurrencyPixPayment" => [
            "route" => "/v1/pagamentos-recorrentes/pix",
            "method" => "GET",
            "scope" => "gn.opb.payment.pix.read"
        ],
        "ofCancelRecurrencyPix" => [
            "route" => "/v1/pagamentos-recorrentes/pix/:identificadorPagamento/cancelar",
            "method" => "PATCH",
            "scope" => "gn.opb.payment.pix.cancel"
        ],
        "ofDevolutionRecurrencyPix" => [
            "route" => "/v1/pagamentos-recorrentes/pix/:identificadorPagamento/devolver",
            "method" => "POST",
            "scope" => "gn.opb.payment.pix.refund"
        ],
        "ofReplaceRecurrencyPixParcel" => [
            "route" => "/v1/pagamentos-recorrentes/pix/:identificadorPagamento/substituir/:endToEndId",
            "method" => "PATCH",
            "scope" => "gn.opb.payment.pix.send"
        ],
        "ofCreateBiometricEnrollment" => [
            "route" => "/v1/pagamentos-biometria/vinculos",
            "method" => "POST",
            "scope" => "gn.opb.jwr.enrollment.write"
        ],
        "ofListBiometricEnrollment" => [
            "route" => "/v1/pagamentos-biometria/vinculos",
            "method" => "GET",
            "scope" => "gn.opb.jwr.enrollment.read"
        ],
        "ofRevokeBiometricEnrollment" => [
            "route" => "/v1/pagamentos-biometria/vinculos",
            "method" => "PATCH",
            "scope" => "gn.opb.jwr.payment.write"
        ],
        "ofCreateBiometricPixPayment" => [
            "route" => "/v1/pagamentos-biometria/pix",
            "method" => "POST",
            "scope" => "gn.opb.jwr.payment.write"
        ],
        "ofListBiometricPixPayment" => [
            "route" => "/v1/pagamentos-biometria/pix",
            "method" => "GET",
            "scope" => "gn.opb.jwr.payment.write"
        ],
        "ofCreateAutomaticEnrollment" => [
            "route" => "/v1/pagamentos-automaticos/adesao",
            "method" => "POST",
            "scope" => "gn.opb.automatic.consent.write"
        ],
        "ofListAutomaticEnrollment" => [
            "route" => "/v1/pagamentos-automaticos/adesao",
            "method" => "GET",
            "scope" => "gn.opb.automatic.consent.read"
        ],
        "ofUpdateAutomaticEnrollment" => [
            "route" => "/v1/pagamentos-automaticos/adesao",
            "method" => "PATCH",
            "scope" => "gn.opb.automatic.consent.write"
        ],
        "ofCreateAutomaticPixPayment" => [
            "route" => "/v1/pagamentos-automaticos/pix",
            "method" => "POST",
            "scope" => "gn.opb.automatic.payment.write"
        ],
        "ofListAutomaticPixPayment" => [
            "route" => "/v1/pagamentos-automaticos/pix",
            "method" => "GET",
            "scope" => "gn.opb.automatic.payment.read"
        ],
        "ofCancelAutomaticPixPayment" => [
            "route" => "/v1/pagamentos-automaticos/pix",
            "method" => "PATCH",
            "scope" => "gn.opb.automatic.payment.write"
        ]
    ]
];
