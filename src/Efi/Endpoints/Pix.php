<?php

return [
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
        "pixResendWebhook" => [
            "route" => "/v2/gn/webhook/reenviar",
            "method" => "post",
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
            "route" => "/v3/gn/pix/:idEnvio",
            "method" => "put",
            "scope" => "pix.send"
        ],
        "pixSendSameOwnership" => [
            "route" => "/v2/gn/pix/:idEnvio/mesma-titularidade",
            "method" => "put",
            "scope" => "gn.pix.sameownership.send"
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
        "pixCreateDueChargeBatch" => [
            "route" => "/v2/lotecobv/:id",
            "method" => "put",
            "scope" => "lotecobv.write"
        ],
        "pixUpdateDueChargeBatch" => [
            "route" => "/v2/lotecobv/:id",
            "method" => "patch",
            "scope" => "lotecobv.write"
        ],
        "pixDetailDueChargeBatch" => [
            "route" => "/v2/lotecobv/:id",
            "method" => "get",
            "scope" => "lotecobv.read"
        ],
        "pixListDueChargeBatch" => [
            "route" => "/v2/lotecobv",
            "method" => "get",
            "scope" => "lotecobv.read"
        ],
        "pixQrCodeDetail" => [
            "route" => "/v2/gn/qrcodes/detalhar",
            "method" => "post",
            "scope" => "gn.qrcodes.read"
        ],
        "pixQrCodePay" => [
            "route" => "/v2/gn/pix/:idEnvio/qrcode",
            "method" => "put",
            "scope" => "gn.qrcodes.pay"
        ],
        "medList" => [
            "route" => "/v2/gn/infracoes",
            "method" => "get",
            "scope" => "gn.infractions.read"
        ],
        "medDefense" => [
            "route" => "/v2/gn/infracoes/:idInfracao/defesa",
            "method" => "post",
            "scope" => "gn.infractions.write"
        ],
        "pixGetReceipt" => [
            "route" => "/v2/gn/pix/comprovantes",
            "method" => "get",
            "scope" => "gn.receipts.read"
        ],
        "pixKeysBucket" => [
            "route" => "/v2/gn/chaves/balde",
            "method" => "get",
            "scope" => "gn.keys.bucket.read"
        ],
        "pixConfigWebhookRecurrenceAutomatic" => [
            "route" => "/v2/webhookrec",
            "method" => "put",
            "scope" => "webhookrec.write"
        ],
        "pixListWebhookRecurrenceAutomatic" => [
            "route" => "/v2/webhookrec",
            "method" => "get",
            "scope" => "webhookrec.read"
        ],
        "pixDeleteWebhookRecurrenceAutomatic" => [
            "route" => "/v2/webhookrec",
            "method" => "delete",
            "scope" => "webhookrec.write"
        ],
        "pixConfigWebhookAutomaticCharge" => [
            "route" => "/v2/webhookcobr",
            "method" => "put",
            "scope" => "webhookcobr.write"
        ],
        "pixListWebhookAutomaticCharge" => [
            "route" => "/v2/webhookcobr",
            "method" => "get",
            "scope" => "webhookcobr.read"
        ],
        "pixDeleteWebhookAutomaticCharge" => [
            "route" => "/v2/webhookcobr",
            "method" => "delete",
            "scope" => "webhookcobr.write"
        ],
        "pixCreateLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec",
            "method" => "post",
            "scope" => "payloadlocationrec.write"
        ],
        "pixListLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec",
            "method" => "get",
            "scope" => "payloadlocationrec.read"
        ],
        "pixDetailLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec/:id",
            "method" => "get",
            "scope" => "payloadlocationrec.read"
        ],
        "pixUnlinkLocationRecurrenceAutomatic" => [
            "route" => "/v2/locrec/:id",
            "method" => "delete",
            "scope" => "payloadlocationrec.write"
        ],
        "pixDetailRecurrenceAutomatic" => [
            "route" => "/v2/rec/:idRec",
            "method" => "get",
            "scope" => "rec.read"
        ],
        "pixUpdateRecurrenceAutomatic" => [
            "route" => "/v2/rec/:idRec",
            "method" => "patch",
            "scope" => "rec.write"
        ],
        "pixListRecurrenceAutomatic" => [
            "route" => "/v2/rec",
            "method" => "get",
            "scope" => "rec.read"
        ],
        "pixCreateRecurrenceAutomatic" => [
            "route" => "/v2/rec",
            "method" => "post",
            "scope" => "rec.write"
        ],
        "pixCreateRequestRecurrenceAutomatic" => [
            "route" => "/v2/solicrec",
            "method" => "post",
            "scope" => "solicrec.write"
        ],
        "pixDetailRequestRecurrenceAutomatic" => [
            "route" => "/v2/solicrec/:idSolicRec",
            "method" => "get",
            "scope" => "solicrec.read"
        ],
        "pixUpdateRequestRecurrenceAutomatic" => [
            "route" => "/v2/solicrec/:idSolicRec",
            "method" => "patch",
            "scope" => "solicrec.write"
        ],
        "pixCreateAutomaticChargeTxid" => [
            "route" => "/v2/cobr/:txid",
            "method" => "put",
            "scope" => "cobr.write"
        ],
        "pixUpdateAutomaticCharge" => [
            "route" => "/v2/cobr/:txid",
            "method" => "patch",
            "scope" => "cobr.write"
        ],
        "pixDetailAutomaticCharge" => [
            "route" => "/v2/cobr/:txid",
            "method" => "get",
            "scope" => "cobr.read"
        ],
        "pixCreateAutomaticCharge" => [
            "route" => "/v2/cobr",
            "method" => "post",
            "scope" => "cobr.write"
        ],
        "pixListAutomaticCharge" => [
            "route" => "/v2/cobr",
            "method" => "get",
            "scope" => "cobr.read"
        ],
        "pixRetryRequestAutomatic" => [
            "route" => "/v2/cobr/:txid/retentativa/:data",
            "method" => "post",
            "scope" => "cobr.write"
        ]
    ]
];
