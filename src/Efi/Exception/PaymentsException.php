<?php

namespace Efi\Exception;

use Exception;

/**
 * Exception class for PAYMENTS API errors in the EFI SDK.
 */
class PaymentsException extends Exception
{
    public $code;
    public $error;
    public $errorDescription;

    public function __construct(array $error, int $code)
    {
        $this->code = $code;
        $this->error = $error['nome'] ?? $error['error'] ?? '';
        $this->errorDescription = $error['mensagem'] ?? $error['error_description'] ?? '';

        if ($this->code === 401) {
            $this->error = 'invalid_client';
            $this->errorDescription = 'Credenciais inválidas ou inativas';
        }

        parent::__construct($this->errorDescription, $this->code);
    }
}
