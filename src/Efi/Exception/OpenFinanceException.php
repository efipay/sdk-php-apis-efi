<?php

namespace Efi\Exception;

use Exception;

/**
 * Exception class for OPEN-FINANCE API errors in the EFI SDK.
 */
class OpenFinanceException extends Exception
{
    public $code;
    public $error;
    public $errorDescription;

    public function __construct(array $error, int $code)
    {
        $this->code = $code;
        $this->error = self::getErrorTitle($error, $this->code);
        $this->errorDescription = self::getErrorDescription($error, $this->code);

        parent::__construct($this->errorDescription, $this->code);
    }

    private static function getErrorTitle(array $error, int $code): string
    {
        if (isset($error['error']) && is_array($error['error']) && isset($error['error']['message'])) {
            return $error['error']['message'];
        }
        return $error['nome'] ?? $error['error'] ?? ($code === 401 ? 'unauthorized' : 'request_error');
    }

    private function getErrorDescription(array $error, int $code): string
    {
        return $error['mensagem'] ?? $error['error_description'] ?? (($code === 401) ? 'Credenciais inválidas ou inativas' : 'Ocorreu um erro. Entre em contato com o suporte Efí para mais detalhes.');
    }
}
