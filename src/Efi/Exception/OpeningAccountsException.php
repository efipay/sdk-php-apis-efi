<?php

namespace Efi\Exception;

use Exception;

/**
 * Exception class for OPENING-ACCOUNTS API errors in the EFI SDK.
 */
class OpeningAccountsException extends Exception
{
    public $code;
    public $error;
    public $errorDescription;

    public function __construct(array $error, int $code)
    {
        $this->code = $code;
        $this->error = $error['nome'] ?? $error['error'] ?? 'Precondition failed';
        $this->errorDescription = $error['mensagem'] ?? $error['error_description'] ?? 'Acesse a documentação API Efí para mais detalhes do código de erro.';

        if ($this->code === 401) {
            $this->error = 'invalid_client';
            $this->errorDescription = 'Credenciais inválidas ou inativas';
        }

        parent::__construct($this->errorDescription, $this->code);
    }
}
