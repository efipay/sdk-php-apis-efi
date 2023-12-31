<?php

return [
    "APIs" => [
        "CHARGES" => [
            "URL" => [
                "production" => "https://cobrancas.api.efipay.com.br",
                "sandbox" => "https://cobrancas-h.api.efipay.com.br"
            ],
            "ENDPOINTS" => [
                "authorize" => [
                    "route" => "/v1/authorize",
                    "method" => "post"
                ],
                "createCharge" => [
                    "route" => "/v1/charge",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createOneStepCharge" => [
                    "route" => "/v1/charge/one-step",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createOneStepChargePartner" => [
                    "route" => "/v1/partner/charge/one-step",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "detailCharge" => [
                    "route" => "/v1/charge/:id",
                    "method" => "get",
                    "scope" => "charge"
                ],
                "updateChargeMetadata" => [
                    "route" => "/v1/charge/:id/metadata",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "updateBillet" => [
                    "route" => "/v1/charge/:id/billet",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "definePayMethod" => [
                    "route" => "/v1/charge/:id/pay",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "definePayMethodPartner" => [
                    "route" => "/v1/partner/charge/:id/pay",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "cancelCharge" => [
                    "route" => "/v1/charge/:id/cancel",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "cardPaymentRetry" => [
                    "route" => "/v1/charge/:id/retry",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createCarnet" => [
                    "route" => "/v1/carnet",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "detailCarnet" => [
                    "route" => "/v1/carnet/:id",
                    "method" => "get",
                    "scope" => "charge"
                ],
                "updateCarnetParcel" => [
                    "route" => "/v1/carnet/:id/parcel/:parcel",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "updateCarnetParcels" => [
                    "route" => "/v1/carnet/:id/parcels",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "updateCarnetMetadata" => [
                    "route" => "/v1/carnet/:id/metadata",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "getNotification" => [
                    "route" => "/v1/notification/:token",
                    "method" => "get",
                    "scope" => "charge"
                ],
                "listPlans" => [
                    "route" => "/v1/plans",
                    "method" => "get",
                    "scope" => "charge"
                ],
                "createPlan" => [
                    "route" => "/v1/plan",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "deletePlan" => [
                    "route" => "/v1/plan/:id",
                    "method" => "delete",
                    "scope" => "charge"
                ],
                "createSubscription" => [
                    "route" => "/v1/plan/:id/subscription",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createOneStepSubscription" => [
                    "route" => "/v1/plan/:id/subscription/one-step",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createOneStepSubscriptionLink" => [
                    "route" => "/v1/plan/:id/subscription/one-step/link",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "detailSubscription" => [
                    "route" => "/v1/subscription/:id",
                    "method" => "get",
                    "scope" => "charge"
                ],
                "defineSubscriptionPayMethod" => [
                    "route" => "/v1/subscription/:id/pay",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "cancelSubscription" => [
                    "route" => "/v1/subscription/:id/cancel",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "updateSubscriptionMetadata" => [
                    "route" => "/v1/subscription/:id/metadata",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "createSubscriptionHistory" => [
                    "route" => "/v1/subscription/:id/history",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "sendSubscriptionLinkEmail" => [
                    "route" => "/v1/charge/:id/subscription/resend",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "getInstallments" => [
                    "route" => "/v1/installments",
                    "method" => "get",
                    "scope" => "charge"
                ],
                "sendBilletEmail" => [
                    "route" => "/v1/charge/:id/billet/resend",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createChargeHistory" => [
                    "route" => "/v1/charge/:id/history",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "sendCarnetEmail" => [
                    "route" => "/v1/carnet/:id/resend",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "sendCarnetParcelEmail" => [
                    "route" => "/v1/carnet/:id/parcel/:parcel/resend",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "createCarnetHistory" => [
                    "route" => "/v1/carnet/:id/history",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "cancelCarnet" => [
                    "route" => "/v1/carnet/:id/cancel",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "cancelCarnetParcel" => [
                    "route" => "/v1/carnet/:id/parcel/:parcel/cancel",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "createOneStepLink" => [
                    "route" => "/v1/charge/one-step/link",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "defineLinkPayMethod" => [
                    "route" => "/v1/charge/:id/link",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "updateChargeLink" => [
                    "route" => "/v1/charge/:id/link",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "sendLinkEmail" => [
                    "route" => "/v1/charge/:id/link/resend",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "updatePlan" => [
                    "route" => "/v1/plan/:id",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "defineBalanceSheetBillet" => [
                    "route" => "/v1/charge/:id/balance-sheet",
                    "method" => "post",
                    "scope" => "charge"
                ],
                "settleCharge" => [
                    "route" => "/v1/charge/:id/settle",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "settleCarnet" => [
                    "route" => "/v1/carnet/:id/settle",
                    "method" => "put",
                    "scope" => "charge"
                ],
                "settleCarnetParcel" => [
                    "route" => "/v1/carnet/:id/parcel/:parcel/settle",
                    "method" => "put",
                    "scope" => "charge"
                ]
            ]
        ],
        "PIX" => [
            "URL" => [
                "production" => "https://pix.api.efipay.com.br",
                "sandbox" => "https://pix-h.api.efipay.com.br"
            ],
            "ENDPOINTS" => [
                "authorize" => [
                    "route" => "/oauth/token",
                    "method" => "post"
                ],
                "pixConfigWebhook" => [
                    "route" => "/v2/webhook/:chave",
                    "method" => "put",
                    "scope" => "webhook.write"
                ],
                "pixDetailWebhook" => [
                    "route" => "/v2/webhook/:chave",
                    "method" => "get",
                    "scope" => "webhook.read"
                ],
                "pixListWebhook" => [
                    "route" => "/v2/webhook",
                    "method" => "get",
                    "scope" => "webhook.read"
                ],
                "pixDeleteWebhook" => [
                    "route" => "/v2/webhook/:chave",
                    "method" => "delete",
                    "scope" => "webhook.write"
                ],
                "pixCreateCharge" => [
                    "route" => "/v2/cob/:txid",
                    "method" => "put",
                    "scope" => "cob.write"
                ],
                "pixCreateImmediateCharge" => [
                    "route" => "/v2/cob",
                    "method" => "post",
                    "scope" => "cob.write"
                ],
                "pixDetailCharge" => [
                    "route" => "/v2/cob/:txid",
                    "method" => "get",
                    "scope" => "cob.read"
                ],
                "pixUpdateCharge" => [
                    "route" => "/v2/cob/:txid",
                    "method" => "patch",
                    "scope" => "cob.write"
                ],
                "pixListCharges" => [
                    "route" => "/v2/cob",
                    "method" => "get",
                    "scope" => "cob.read"
                ],
                "pixDevolution" => [
                    "route" => "/v2/pix/:e2eId/devolucao/:id",
                    "method" => "put",
                    "scope" => "pix.write"
                ],
                "pixDetailDevolution" => [
                    "route" => "/v2/pix/:e2eId/devolucao/:id",
                    "method" => "get",
                    "scope" => "pix.read"
                ],
                "pixSend" => [
                    "route" => "/v2/gn/pix/:idEnvio",
                    "method" => "put",
                    "scope" => "pix.send"
                ],
                "pixSendDetail" => [
                    "route" => "/v2/gn/pix/enviados/:e2eId",
                    "method" => "get",
                    "scope" => "gn.pix.send.read"
                ],
                "pixSendDetailId" => [
                    "route" => "/v2/gn/pix/enviados/id-envio/:idEnvio",
                    "method" => "get",
                    "scope" => "gn.pix.send.read"
                ],
                "pixSendList" => [
                    "route" => "/v2/gn/pix/enviados",
                    "method" => "get",
                    "scope" => "gn.pix.send.read"
                ],
                "pixDetailReceived" => [
                    "route" => "/v2/pix/:e2eId",
                    "method" => "get",
                    "scope" => "pix.read"
                ],
                "pixReceivedList" => [
                    "route" => "/v2/pix",
                    "method" => "get",
                    "scope" => "pix.read"
                ],
                "pixGenerateQRCode" => [
                    "route" => "/v2/loc/:id/qrcode",
                    "method" => "get",
                    "scope" => "payloadlocation.read"
                ],
                "pixCreateLocation" => [
                    "route" => "/v2/loc",
                    "method" => "post",
                    "scope" => "payloadlocation.write"
                ],
                "pixLocationList" => [
                    "route" => "/v2/loc",
                    "method" => "get",
                    "scope" => "payloadlocation.read"
                ],
                "pixDetailLocation" => [
                    "route" => "/v2/loc/:id",
                    "method" => "get",
                    "scope" => "payloadlocation.read"
                ],
                "pixUnlinkTxidLocation" => [
                    "route" => "/v2/loc/:id/txid",
                    "method" => "delete",
                    "scope" => "payloadlocation.write"
                ],
                "pixCreateEvp" => [
                    "route" => "/v2/gn/evp",
                    "method" => "post",
                    "scope" => "gn.pix.evp.write"
                ],
                "pixListEvp" => [
                    "route" => "/v2/gn/evp",
                    "method" => "get",
                    "scope" => "gn.pix.evp.read"
                ],
                "pixDeleteEvp" => [
                    "route" => "/v2/gn/evp/:chave",
                    "method" => "delete",
                    "scope" => "gn.pix.evp.write"
                ],
                "pixSplitDetailCharge" => [
                    "route" => "/v2/gn/split/cob/:txid",
                    "method" => "get",
                    "scope" => "gn.split.read"
                ],
                "pixSplitLinkCharge" => [
                    "route" => "/v2/gn/split/cob/:txid/vinculo/:splitConfigId",
                    "method" => "put",
                    "scope" => "gn.split.write"
                ],
                "pixSplitUnlinkCharge" => [
                    "route" => "/v2/gn/split/cob/:txid/vinculo/",
                    "method" => "delete",
                    "scope" => "gn.split.write"
                ],
                "pixSplitDetailDueCharge" => [
                    "route" => "/v2/gn/split/cobv/:txid",
                    "method" => "get",
                    "scope" => "gn.split.read"
                ],
                "pixSplitLinkDueCharge" => [
                    "route" => "/v2/gn/split/cobv/:txid/vinculo/:splitConfigId",
                    "method" => "put",
                    "scope" => "gn.split.write"
                ],
                "pixSplitUnlinkDueCharge" => [
                    "route" => "/v2/gn/split/cobv/:txid/vinculo",
                    "method" => "delete",
                    "scope" => "gn.split.write"
                ],
                "pixSplitConfig" => [
                    "route" => "/v2/gn/split/config",
                    "method" => "post",
                    "scope" => "gn.split.write"
                ],
                "pixSplitConfigId" => [
                    "route" => "/v2/gn/split/config/:id",
                    "method" => "put",
                    "scope" => "gn.split.write"
                ],
                "pixSplitDetailConfig" => [
                    "route" => "/v2/gn/split/config/:id",
                    "method" => "get",
                    "scope" => "gn.split.read"
                ],
                "getAccountBalance" => [
                    "route" => "/v2/gn/saldo",
                    "method" => "get",
                    "scope" => "gn.balance.read"
                ],
                "updateAccountConfig" => [
                    "route" => "/v2/gn/config",
                    "method" => "put",
                    "scope" => "gn.settings.write"
                ],
                "listAccountConfig" => [
                    "route" => "/v2/gn/config",
                    "method" => "get",
                    "scope" => "gn.settings.read"
                ],
                "pixCreateDueCharge" => [
                    "route" => "/v2/cobv/:txid",
                    "method" => "put",
                    "scope" => "cobv.write"
                ],
                "pixUpdateDueCharge" => [
                    "route" => "/v2/cobv/:txid",
                    "method" => "patch",
                    "scope" => "cobv.write"
                ],
                "pixDetailDueCharge" => [
                    "route" => "/v2/cobv/:txid",
                    "method" => "get",
                    "scope" => "cobv.read"
                ],
                "pixListDueCharges" => [
                    "route" => "/v2/cobv",
                    "method" => "get",
                    "scope" => "cobv.read"
                ],
                "createReport" => [
                    "route" => "/v2/gn/relatorios/extrato-conciliacao",
                    "method" => "post",
                    "scope" => "gn.reports.write"
                ],
                "detailReport" => [
                    "route" => "/v2/gn/relatorios/:id",
                    "method" => "get",
                    "scope" => "gn.reports.read"
                ],
                "pixCreateCobvBatch" => [
                    "route" => "v2/lotecobv/:id",
                    "method" => "put",
                    "scope" => "lotecobv.write"
                ],
                "pixUpdateCobvBatch" => [
                    "route" => "v2/lotecobv/:id",
                    "method" => "patch",
                    "scope" => "lotecobv.write"
                ],
                "pixDetailCobvBatch" => [
                    "route" => "v2/lotecobv/:id",
                    "method" => "get",
                    "scope" => "lotecobv.read"
                ],
                "pixListCobvBatch" => [
                    "route" => "v2/lotecobv",
                    "method" => "get",
                    "scope" => "lotecobv.read"
                ]
            ]
        ],
        "OPEN-FINANCE" => [
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
        ],
        "PAYMENTS" => [
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
        ],
        "OPENING-ACCOUNTS" => [
            "URL" => [
                "production" => "https://abrircontas.api.efipay.com.br",
                "sandbox" => "https://abrircontas-h.api.efipay.com.br"
            ],
            "ENDPOINTS" => [
                "authorize" => [
                    "route" => "/v1/oauth/token",
                    "method" => "post"
                ],
                "createAccount" => [
                    "route" => "/v1/conta-simplificada",
                    "method" => "post",
                    "scope" => "gn.registration.write"
                ],
                "getAccountCredentials" => [
                    "route" => "/v1/conta-simplificada/:idContaSimplificada/credenciais",
                    "method" => "get",
                    "scope" => "gn.registration.read"
                ],
                "createAccountCertificate" => [
                    "route" => "/v1/conta-simplificada/:idContaSimplificada/certificado",
                    "method" => "post",
                    "scope" => "gn.registration.read"
                ],
                "accountConfigWebhook" => [
                    "route" => "/v1/webhook",
                    "method" => "post",
                    "scope" => "gn.registration.webhook.write"
                ],
                "accountListWebhook" => [
                    "route" => "/v1/webhooks",
                    "method" => "get",
                    "scope" => "gn.registration.webhook.read"
                ],
                "accountDetailWebhook" => [
                    "route" => "/v1/webhook/:identificadorWebhook",
                    "method" => "get",
                    "scope" => "gn.registration.webhook.read"
                ],
                "accountDeleteWebhook" => [
                    "route" => "/v1/webhook/:identificadorWebhook",
                    "method" => "delete",
                    "scope" => "gn.registration.webhook.write"
                ]
            ]
        ]
    ]
];
