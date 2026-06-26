<?php

return [
    "URL" => [
        "production" => "https://cobrancas.api.efipay.com.br",
        "sandbox" => "https://cobrancas-h.api.efipay.com.br"
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/authorize",
            "method" => "POST"
        ],
        "createCharge" => [
            "route" => "/v1/charge",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createChargeCard" => [
            "route" => "/v2/charge/card",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createOneStepCharge" => [
            "route" => "/v1/charge/one-step",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createOneStepChargePartner" => [
            "route" => "/v1/partner/charge/one-step",
            "method" => "POST",
            "scope" => "charge"
        ],
        "detailCharge" => [
            "route" => "/v1/charge/:id",
            "method" => "GET",
            "scope" => "charge"
        ],
        "listCharges" => [
            "route" => "/v1/charges",
            "method" => "GET",
            "scope" => "charge"
        ],
        "updateChargeMetadata" => [
            "route" => "/v1/charge/:id/metadata",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "updateBillet" => [
            "route" => "/v1/charge/:id/billet",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "definePayMethod" => [
            "route" => "/v1/charge/:id/pay",
            "method" => "POST",
            "scope" => "charge"
        ],
        "definePayMethodPartner" => [
            "route" => "/v1/partner/charge/:id/pay",
            "method" => "POST",
            "scope" => "charge"
        ],
        "cancelCharge" => [
            "route" => "/v1/charge/:id/cancel",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "cardPaymentRetry" => [
            "route" => "/v1/charge/:id/retry",
            "method" => "POST",
            "scope" => "charge"
        ],
        "refundCard" => [
            "route" => "/v1/charge/card/:id/refund",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createCarnet" => [
            "route" => "/v1/carnet",
            "method" => "POST",
            "scope" => "charge"
        ],
        "detailCarnet" => [
            "route" => "/v1/carnet/:id",
            "method" => "GET",
            "scope" => "charge"
        ],
        "updateCarnetParcel" => [
            "route" => "/v1/carnet/:id/parcel/:parcel",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "updateCarnetParcels" => [
            "route" => "/v1/carnet/:id/parcels",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "updateCarnetMetadata" => [
            "route" => "/v1/carnet/:id/metadata",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "getNotification" => [
            "route" => "/v1/notification/:token",
            "method" => "GET",
            "scope" => "charge"
        ],
        "listPlans" => [
            "route" => "/v1/plans",
            "method" => "GET",
            "scope" => "charge"
        ],
        "createPlan" => [
            "route" => "/v1/plan",
            "method" => "POST",
            "scope" => "charge"
        ],
        "deletePlan" => [
            "route" => "/v1/plan/:id",
            "method" => "DELETE",
            "scope" => "charge"
        ],
        "createSubscription" => [
            "route" => "/v1/plan/:id/subscription",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createOneStepSubscription" => [
            "route" => "/v1/plan/:id/subscription/one-step",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createOneStepSubscriptionLink" => [
            "route" => "/v1/plan/:id/subscription/one-step/link",
            "method" => "POST",
            "scope" => "charge"
        ],
        "detailSubscription" => [
            "route" => "/v1/subscription/:id",
            "method" => "GET",
            "scope" => "charge"
        ],
        "defineSubscriptionPayMethod" => [
            "route" => "/v1/subscription/:id/pay",
            "method" => "POST",
            "scope" => "charge"
        ],
        "cancelSubscription" => [
            "route" => "/v1/subscription/:id/cancel",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "updateSubscription" => [
            "route" => "/v1/subscription/:id",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "updateSubscriptionMetadata" => [
            "route" => "/v1/subscription/:id/metadata",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "createSubscriptionHistory" => [
            "route" => "/v1/subscription/:id/history",
            "method" => "POST",
            "scope" => "charge"
        ],
        "sendSubscriptionLinkEmail" => [
            "route" => "/v1/charge/:id/subscription/resend",
            "method" => "POST",
            "scope" => "charge"
        ],
        "getInstallments" => [
            "route" => "/v1/installments",
            "method" => "GET",
            "scope" => "charge"
        ],
        "sendBilletEmail" => [
            "route" => "/v1/charge/:id/billet/resend",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createChargeHistory" => [
            "route" => "/v1/charge/:id/history",
            "method" => "POST",
            "scope" => "charge"
        ],
        "sendCarnetEmail" => [
            "route" => "/v1/carnet/:id/resend",
            "method" => "POST",
            "scope" => "charge"
        ],
        "sendCarnetParcelEmail" => [
            "route" => "/v1/carnet/:id/parcel/:parcel/resend",
            "method" => "POST",
            "scope" => "charge"
        ],
        "createCarnetHistory" => [
            "route" => "/v1/carnet/:id/history",
            "method" => "POST",
            "scope" => "charge"
        ],
        "cancelCarnet" => [
            "route" => "/v1/carnet/:id/cancel",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "cancelCarnetParcel" => [
            "route" => "/v1/carnet/:id/parcel/:parcel/cancel",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "createOneStepLink" => [
            "route" => "/v1/charge/one-step/link",
            "method" => "POST",
            "scope" => "charge"
        ],
        "defineLinkPayMethod" => [
            "route" => "/v1/charge/:id/link",
            "method" => "POST",
            "scope" => "charge"
        ],
        "updateChargeLink" => [
            "route" => "/v1/charge/:id/link",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "sendLinkEmail" => [
            "route" => "/v1/charge/:id/link/resend",
            "method" => "POST",
            "scope" => "charge"
        ],
        "updatePlan" => [
            "route" => "/v1/plan/:id",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "defineBalanceSheetBillet" => [
            "route" => "/v1/charge/:id/balance-sheet",
            "method" => "POST",
            "scope" => "charge"
        ],
        "settleCharge" => [
            "route" => "/v1/charge/:id/settle",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "settleCarnet" => [
            "route" => "/v1/carnet/:id/settle",
            "method" => "PUT",
            "scope" => "charge"
        ],
        "settleCarnetParcel" => [
            "route" => "/v1/carnet/:id/parcel/:parcel/settle",
            "method" => "PUT",
            "scope" => "charge"
        ]
    ]
];
