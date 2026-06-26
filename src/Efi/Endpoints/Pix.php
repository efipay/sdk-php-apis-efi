<?php

return [
    "URL" => [
        "production" => "https://pix.api.efipay.com.br",
        "sandbox" => "https://pix-h.api.efipay.com.br"
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/oauth/token",
            "method" => "POST"
        ],
        "pixConfigWebhook" => [
            "route" => "/v2/webhook/:chave",
            "method" => "PUT",
            "scope" => "webhook.write"
        ],
        "pixDetailWebhook" => [
            "route" => "/v2/webhook/:chave",
            "method" => "GET",
            "scope" => "webhook.read"
        ],
        "pixListWebhook" => [
            "route" => "/v2/webhook",
            "method" => "GET",
            "scope" => "webhook.read"
        ],
        "pixDeleteWebhook" => [
            "route" => "/v2/webhook/:chave",
            "method" => "DELETE",
            "scope" => "webhook.write"
        ],
        "pixResendWebhook" => [
            "route" => "/v2/gn/webhook/reenviar",
            "method" => "POST",
            "scope" => "webhook.write"
        ],
        "pixCreateCharge" => [
            "route" => "/v2/cob/:txid",
            "method" => "PUT",
            "scope" => "cob.write"
        ],
        "pixCreateImmediateCharge" => [
            "route" => "/v2/cob",
            "method" => "POST",
            "scope" => "cob.write"
        ],
        "pixDetailCharge" => [
            "route" => "/v2/cob/:txid",
            "method" => "GET",
            "scope" => "cob.read"
        ],
        "pixUpdateCharge" => [
            "route" => "/v2/cob/:txid",
            "method" => "PATCH",
            "scope" => "cob.write"
        ],
        "pixListCharges" => [
            "route" => "/v2/cob",
            "method" => "GET",
            "scope" => "cob.read"
        ],
        "pixDevolution" => [
            "route" => "/v2/pix/:e2eId/devolucao/:id",
            "method" => "PUT",
            "scope" => "pix.write"
        ],
        "pixDetailDevolution" => [
            "route" => "/v2/pix/:e2eId/devolucao/:id",
            "method" => "GET",
            "scope" => "pix.read"
        ],
        "pixSend" => [
            "route" => "/v3/gn/pix/:idEnvio",
            "method" => "PUT",
            "scope" => "pix.send"
        ],
        "pixSendSameOwnership" => [
            "route" => "/v2/gn/pix/:idEnvio/mesma-titularidade",
            "method" => "PUT",
            "scope" => "gn.pix.sameownership.send"
        ],
        "pixSendDetail" => [
            "route" => "/v2/gn/pix/enviados/:e2eId",
            "method" => "GET",
            "scope" => "gn.pix.send.read"
        ],
        "pixSendDetailId" => [
            "route" => "/v2/gn/pix/enviados/id-envio/:idEnvio",
            "method" => "GET",
            "scope" => "gn.pix.send.read"
        ],
        "pixSendList" => [
            "route" => "/v2/gn/pix/enviados",
            "method" => "GET",
            "scope" => "gn.pix.send.read"
        ],
        "pixDetailReceived" => [
            "route" => "/v2/pix/:e2eId",
            "method" => "GET",
            "scope" => "pix.read"
        ],
        "pixReceivedList" => [
            "route" => "/v2/pix",
            "method" => "GET",
            "scope" => "pix.read"
        ],
        "pixGenerateQRCode" => [
            "route" => "/v2/loc/:id/qrcode",
            "method" => "GET",
            "scope" => "payloadlocation.read"
        ],
        "pixCreateLocation" => [
            "route" => "/v2/loc",
            "method" => "POST",
            "scope" => "payloadlocation.write"
        ],
        "pixLocationList" => [
            "route" => "/v2/loc",
            "method" => "GET",
            "scope" => "payloadlocation.read"
        ],
        "pixDetailLocation" => [
            "route" => "/v2/loc/:id",
            "method" => "GET",
            "scope" => "payloadlocation.read"
        ],
        "pixUnlinkTxidLocation" => [
            "route" => "/v2/loc/:id/txid",
            "method" => "DELETE",
            "scope" => "payloadlocation.write"
        ],
        "pixCreateEvp" => [
            "route" => "/v2/gn/evp",
            "method" => "POST",
            "scope" => "gn.pix.evp.write"
        ],
        "pixListEvp" => [
            "route" => "/v2/gn/evp",
            "method" => "GET",
            "scope" => "gn.pix.evp.read"
        ],
        "pixDeleteEvp" => [
            "route" => "/v2/gn/evp/:chave",
            "method" => "DELETE",
            "scope" => "gn.pix.evp.write"
        ],
        "pixSplitDetailCharge" => [
            "route" => "/v2/gn/split/cob/:txid",
            "method" => "GET",
            "scope" => "gn.split.read"
        ],
        "pixSplitLinkCharge" => [
            "route" => "/v2/gn/split/cob/:txid/vinculo/:splitConfigId",
            "method" => "PUT",
            "scope" => "gn.split.write"
        ],
        "pixSplitUnlinkCharge" => [
            "route" => "/v2/gn/split/cob/:txid/vinculo/",
            "method" => "DELETE",
            "scope" => "gn.split.write"
        ],
        "pixSplitDetailDueCharge" => [
            "route" => "/v2/gn/split/cobv/:txid",
            "method" => "GET",
            "scope" => "gn.split.read"
        ],
        "pixSplitLinkDueCharge" => [
            "route" => "/v2/gn/split/cobv/:txid/vinculo/:splitConfigId",
            "method" => "PUT",
            "scope" => "gn.split.write"
        ],
        "pixSplitUnlinkDueCharge" => [
            "route" => "/v2/gn/split/cobv/:txid/vinculo",
            "method" => "DELETE",
            "scope" => "gn.split.write"
        ],
        "pixSplitConfig" => [
            "route" => "/v2/gn/split/config",
            "method" => "POST",
            "scope" => "gn.split.write"
        ],
        "pixSplitConfigId" => [
            "route" => "/v2/gn/split/config/:id",
            "method" => "PUT",
            "scope" => "gn.split.write"
        ],
        "pixSplitDetailConfig" => [
            "route" => "/v2/gn/split/config/:id",
            "method" => "GET",
            "scope" => "gn.split.read"
        ],
        "getAccountBalance" => [
            "route" => "/v2/gn/saldo",
            "method" => "GET",
            "scope" => "gn.balance.read"
        ],
        "updateAccountConfig" => [
            "route" => "/v2/gn/config",
            "method" => "PUT",
            "scope" => "gn.settings.write"
        ],
        "listAccountConfig" => [
            "route" => "/v2/gn/config",
            "method" => "GET",
            "scope" => "gn.settings.read"
        ],
        "pixCreateDueCharge" => [
            "route" => "/v2/cobv/:txid",
            "method" => "PUT",
            "scope" => "cobv.write"
        ],
        "pixUpdateDueCharge" => [
            "route" => "/v2/cobv/:txid",
            "method" => "PATCH",
            "scope" => "cobv.write"
        ],
        "pixDetailDueCharge" => [
            "route" => "/v2/cobv/:txid",
            "method" => "GET",
            "scope" => "cobv.read"
        ],
        "pixListDueCharges" => [
            "route" => "/v2/cobv",
            "method" => "GET",
            "scope" => "cobv.read"
        ],
        "createReport" => [
            "route" => "/v2/gn/relatorios/extrato-conciliacao",
            "method" => "POST",
            "scope" => "gn.reports.write"
        ],
        "detailReport" => [
            "route" => "/v2/gn/relatorios/:id",
            "method" => "GET",
            "scope" => "gn.reports.read"
        ],
        "pixCreateDueChargeBatch" => [
            "route" => "/v2/lotecobv/:id",
            "method" => "PUT",
            "scope" => "lotecobv.write"
        ],
        "pixUpdateDueChargeBatch" => [
            "route" => "/v2/lotecobv/:id",
            "method" => "PATCH",
            "scope" => "lotecobv.write"
        ],
        "pixDetailDueChargeBatch" => [
            "route" => "/v2/lotecobv/:id",
            "method" => "GET",
            "scope" => "lotecobv.read"
        ],
        "pixListDueChargeBatch" => [
            "route" => "/v2/lotecobv",
            "method" => "GET",
            "scope" => "lotecobv.read"
        ],
        "pixQrCodeDetail" => [
            "route" => "/v2/gn/qrcodes/detalhar",
            "method" => "POST",
            "scope" => "gn.qrcodes.read"
        ],
        "pixQrCodePay" => [
            "route" => "/v2/gn/pix/:idEnvio/qrcode",
            "method" => "PUT",
            "scope" => "gn.qrcodes.pay"
        ],
        "medList" => [
            "route" => "/v2/gn/infracoes",
            "method" => "GET",
            "scope" => "gn.infractions.read"
        ],
        "medDefense" => [
            "route" => "/v2/gn/infracoes/:idInfracao/defesa",
            "method" => "POST",
            "scope" => "gn.infractions.write"
        ],
        "pixGetReceipt" => [
            "route" => "/v2/gn/pix/comprovantes",
            "method" => "GET",
            "scope" => "gn.receipts.read"
        ],
        "pixKeysBucket" => [
            "route" => "/v2/gn/chaves/balde",
            "method" => "GET",
            "scope" => "gn.keys.bucket.read"
        ],
        "pixConfigWebhookRecurrenceAutomatic" => [
            "route" => "/v2/webhookrec",
            "method" => "PUT",
            "scope" => "webhookrec.write"
        ],
        "pixListWebhookRecurrenceAutomatic" => [
            "route" => "/v2/webhookrec",
            "method" => "GET",
            "scope" => "webhookrec.read"
        ],
        "pixDeleteWebhookRecurrenceAutomatic" => [
            "route" => "/v2/webhookrec",
            "method" => "DELETE",
            "scope" => "webhookrec.write"
        ],
        "pixConfigWebhookAutomaticCharge" => [
            "route" => "/v2/webhookcobr",
            "method" => "PUT",
            "scope" => "webhookcobr.write"
        ],
        "pixListWebhookAutomaticCharge" => [
            "route" => "/v2/webhookcobr",
            "method" => "GET",
            "scope" => "webhookcobr.read"
        ],
        "pixDeleteWebhookAutomaticCharge" => [
            "route" => "/v2/webhookcobr",
            "method" => "DELETE",
            "scope" => "webhookcobr.write"
        ],
        "pixCreateLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec",
            "method" => "POST",
            "scope" => "payloadlocationrec.write"
        ],
        "pixListLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec",
            "method" => "GET",
            "scope" => "payloadlocationrec.read"
        ],
        "pixDetailLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec/:id",
            "method" => "GET",
            "scope" => "payloadlocationrec.read"
        ],
        "pixUnlinkLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec/:id",
            "method" => "DELETE",
            "scope" => "payloadlocationrec.write"
        ],
        "pixDetailRecurrenceAutomatic" => [
            "route" => "/v2/rec/:idRec",
            "method" => "GET",
            "scope" => "rec.read"
        ],
        "pixUpdateRecurrenceAutomatic" => [
            "route" => "/v2/rec/:idRec",
            "method" => "PATCH",
            "scope" => "rec.write"
        ],
        "pixListRecurrenceAutomatic" => [
            "route" => "/v2/rec",
            "method" => "GET",
            "scope" => "rec.read"
        ],
        "pixCreateRecurrenceAutomatic" => [
            "route" => "/v2/rec",
            "method" => "POST",
            "scope" => "rec.write"
        ],
        "pixCreateRequestRecurrenceAutomatic" => [
            "route" => "/v2/solicrec",
            "method" => "POST",
            "scope" => "solicrec.write"
        ],
        "pixDetailRequestRecurrenceAutomatic" => [
            "route" => "/v2/solicrec/:idSolicRec",
            "method" => "GET",
            "scope" => "solicrec.read"
        ],
        "pixUpdateRequestRecurrenceAutomatic" => [
            "route" => "/v2/solicrec/:idSolicRec",
            "method" => "PATCH",
            "scope" => "solicrec.write"
        ],
        "pixCreateAutomaticChargeTxid" => [
            "route" => "/v2/cobr/:txid",
            "method" => "PUT",
            "scope" => "cobr.write"
        ],
        "pixUpdateAutomaticCharge" => [
            "route" => "/v2/cobr/:txid",
            "method" => "PATCH",
            "scope" => "cobr.write"
        ],
        "pixDetailAutomaticCharge" => [
            "route" => "/v2/cobr/:txid",
            "method" => "GET",
            "scope" => "cobr.read"
        ],
        "pixCreateAutomaticCharge" => [
            "route" => "/v2/cobr",
            "method" => "POST",
            "scope" => "cobr.write"
        ],
        "pixListAutomaticCharge" => [
            "route" => "/v2/cobr",
            "method" => "GET",
            "scope" => "cobr.read"
        ],
        "pixRetryRequestAutomatic" => [
            "route" => "/v2/cobr/:txid/retentativa/:data",
            "method" => "POST",
            "scope" => "cobr.write"
        ]
    ]
];
