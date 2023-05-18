<?php

namespace Efi\Exception;

use Exception;
use GuzzleHttp\Psr7\Stream;

class EfiPayException extends Exception
{
    private $error;
    private $errorDescription;

    public function __construct($exception, $code)
    {
        $error = $exception;

        if ($exception instanceof Stream) {
            $error = $this->parseStream($exception);
        }

        $this->apiReturns($error, $code);
    }

    private function apiReturns($error, $code)
    {
        if (isset($error['message'])) {
            $this->message = $error['message'];
            $this->code = $code;
            $this->errorDescription = $error['message'];
        } elseif (isset($error['error'])) {  // error API Cobranças
            $message = isset($error['error_description']['message']) ? $error['error_description']['message'] : $error['error_description'];

            $this->code = $error['code'];
            $this->error = $error['error'];
            $this->errorDescription = $error['error_description'];
        } elseif (isset($error['type'])) { // error API cobv e reports
            $this->code = $error['status'];
            $this->error = $error['title'];
            $this->errorDescription = $error['violacoes'] ?? $error['detail'];
        } else { // error API Pix
            $message = isset($error['erros']['mensagem']) ?  $error['mensagem'] . ": " . $error['caminho'] . " " . $error['erros']['mensagem'] : $error['mensagem'] . ": " . $error['mensagem'];

            $this->code = $code;
            $this->error = isset($error['erros']) ?  $error['mensagem'] : $error['nome'];
            $this->errorDescription = isset($error['erros']) ?  $error['erros'] : $error['mensagem'];
        }

        parent::__construct($message, $this->code);
    }

    /**
     * Parses the error stream and returns the error as an array.
     *
     * @param Stream $stream The error stream.
     * @return array The parsed error array.
     */
    private function parseStream(Stream $stream)
    {
        $error = '';
        while (!$stream->eof()) {
            $error .= $stream->read(1024);
        }

        return json_decode($error, true);
    }

    /**
     * Returns a string representation of the exception.
     *
     * @return string The string representation of the exception.
     */
    public function __toString()
    {
        return 'Error ' . $this->code . ': ' . $this->message . "\n";
    }

    /**
     * Magic getter method to access the properties of the exception.
     *
     * @param string $property The property name.
     * @return mixed|null The value of the property or null if it doesn't exist.
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }
}
