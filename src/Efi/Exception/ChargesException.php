<?php

namespace Efi\Exception;

use Exception;

/**
 * Exception class for CHARGES API errors in the EFI SDK.
 */
class ChargesException extends Exception
{
    public $code;
    public $error;
    public $errorDescription;

    public function __construct(array $error, int $code)
    {
        $this->code = $error['code'] ?? $code;
        $this->error = $error['error'] ?? '';
        $this->errorDescription = $this->getErrorDescription($error);

        if ($this->code === 401) {
            $this->error = 'unauthorized';
            $this->errorDescription = 'Credenciais inválidas ou inativas';
        }

        parent::__construct($this->errorDescription, $this->code);
    }

    private function getErrorDescription(array $error)
    {
        if (isset($error['error_description'])) {
            if (is_array($error['error_description'])) {
                return isset($error['error_description']['message'])
                    ? 'Propriedade: "' . $error['error_description']['property'] . '". ' . $error['error_description']['message']
                    : $error['error_description'];
            } else {
                return $error['error_description'];
            }
        }

        if (isset($error['error']) && isset($error['error_description'])) {
            return $error['error_description'];
        }

        return '';
    }
}
