<?php

return [
    "URL" => [
        "production" => "https://extratos.api.efipay.com.br",
        "sandbox" => null
    ],
    "ENDPOINTS" => [
        "authorize" => [
            "route" => "/v1/oauth/token",
            "method" => "post"
        ],
        "listStatementFiles" => [
            "route" => "/v1/extrato-cnab/arquivos",
            "method" => "get",
            "scope" => "gn.cnab-statement.statement.read"
        ],
        "getStatementFile" => [
            "route" => "/v1/extrato-cnab/download/:nome_arquivo",
            "method" => "get",
            "scope" => "gn.cnab-statement.statement.read"
        ],
        "listStatementRecurrences" => [
            "route" => "/v1/extrato-cnab/agendamentos",
            "method" => "get",
            "scope" => "gn.cnab-statement.statement.read"
        ],
        "createStatementRecurrency" => [
            "route" => "/v1/extrato-cnab/agendar",
            "method" => "post",
            "scope" => "gn.cnab-statement.statement.write"
        ],
        "updateStatementRecurrency" => [
            "route" => "/v1/extrato-cnab/agendar/:identificador",
            "method" => "patch",
            "scope" => "gn.cnab-statement.statement.write"
        ],
        "createSftpKey" => [
            "route" => "/v1/extrato-cnab/gerar-chaves",
            "method" => "post",
            "scope" => "gn.cnab-statement.statement.write"
        ],
    ]
];
