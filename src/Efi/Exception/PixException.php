<?php

namespace Efi\Exception;

use Exception;

/**
 * Exception class for PIX API errors in the EFI SDK.
 */
class PixException extends Exception
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
        return $error['nome'] ?? ($error['title'] ?? $error['error'] ?? ($code === 401 ? 'unauthorized' : 'request_error'));
    }

    private function getErrorDescription(array $error, int $code): string
    {
        if (isset($error['detail'])) {
            $description = $error['detail'];
            if (isset($error['violacoes']) && is_array($error['violacoes'])) {
                foreach ($error['violacoes'] as $violacao) {
                    if (isset($violacao['razao'])) {
                        $description .= ' Propriedade: "' . $violacao['propriedade'] . '". ' . $violacao['razao'];
                    }
                }
            }
            return $description;
        }

        if (isset($error['mensagem'])) {
            $messageDetail = json_decode($error['mensagem'], true);
            if (is_array($messageDetail) && isset($messageDetail['detail'])) {
                return $messageDetail['detail'];
            }
    
            if (isset($error['erros']) && is_array($error['erros'])) {
                $errorMessages = [];
                foreach ($error['erros'] as $errorItem) {
                    if (!empty($errorItem['mensagem']) && !empty($errorItem['caminho'])) {
                        $errorMessages[] = 'Parâmetro "' . $errorItem['caminho'] . '", ' . $errorItem['mensagem'];
                    }
                }
                return implode('. ', $errorMessages);
            }
    
            return $error['mensagem'];
        }

        if (isset($error['error_description'])) {
            return $error['error_description'];
        }

        return ($code === 401) ? 'Credenciais inválidas ou inativas' : 'Ocorreu um erro. Entre em contato com o suporte Efí para mais detalhes.';
    }
}
