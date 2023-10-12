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
        $this->error = $this->getErrorTitle($error);
        $this->errorDescription = $this->getErrorDescription($error);

        if ($this->code === 401) {
            $this->error = 'invalid_client';
            $this->errorDescription = 'Credenciais inválidas ou inativas';
        }

        parent::__construct($this->errorDescription, $this->code);
    }

    private function getErrorTitle(array $error)
    {
        return $error['nome'] ?? ($error['title'] ?? '');
    }

    private function getErrorDescription(array $error)
    {
        if (isset($error['detail'])) {
            $description = $error['detail'];
            if (isset($error['violacoes'][0]['razao'])) {
                $description .= ' Propriedade: "' . $error['violacoes'][0]['propriedade'] . '". ' . $error['violacoes'][0]['razao'];
            }
            return $description;
        }

        if (isset($error['mensagem'])) {
            $messageDetail = json_decode($error['mensagem'], true);
            if (is_array($messageDetail) && isset($messageDetail['detail'])) {
                return $messageDetail['detail'];
            }
            return !empty($error['erros'][0]['mensagem']) && !empty($error['erros'][0]['caminho'])
                ? $error['mensagem'] . '. Parâmetro "' . $error['erros'][0]['caminho'] . '" ' . $error['erros'][0]['mensagem']
                : $error['mensagem'];
        }
        
        return 'Ocorreu um erro. Entre em contato com o suporte Efí para mais detalhes.';
    }
}
