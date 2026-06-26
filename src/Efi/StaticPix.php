<?php

declare(strict_types=1);

namespace Efi;

use Efi\Exception\EfiException;

class StaticPix
{
    private const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    private const ID_POINT_OF_INITIATION_METHOD = '01';
    private const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    private const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    private const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    private const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    private const ID_MERCHANT_CATEGORY_CODE = '52';
    private const ID_TRANSACTION_CURRENCY = '53';
    private const ID_TRANSACTION_AMOUNT = '54';
    private const ID_COUNTRY_CODE = '58';
    private const ID_MERCHANT_NAME = '59';
    private const ID_MERCHANT_CITY = '60';
    private const ID_MERCHANT_POSTAL_CODE = '61';
    private const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    private const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    private const ID_CRC16 = '63';

    public function create(array $data): string
    {
        $this->validateInput($data);

        $singlePayment = $data['pagamentoUnico'] ?? true;

        $transactionAmount = isset($data['valor']) ? $this->formatValue(self::ID_TRANSACTION_AMOUNT, $data['valor']) : '';

        $payload = $this->formatValue(self::ID_PAYLOAD_FORMAT_INDICATOR, '01') .
            ($singlePayment ? $this->formatValue(self::ID_POINT_OF_INITIATION_METHOD, '12') : '') .
            $this->buildMerchantAccountInformation($data) .
            $this->formatValue(self::ID_MERCHANT_CATEGORY_CODE, '0000') .
            $this->formatValue(self::ID_TRANSACTION_CURRENCY, '986') .
            $transactionAmount .
            $this->formatValue(self::ID_COUNTRY_CODE, 'BR') .
            $this->formatValue(self::ID_MERCHANT_NAME, $this->sanitize($data['nomeRecebedor'])) .
            $this->formatValue(self::ID_MERCHANT_CITY, $this->sanitize($data['cidade'])) .
            $this->buildOptionalFields($data) .
            $this->buildAdditionalDataField($data);

        return $payload . $this->calculateCRC16($payload);
    }

    private function validateInput(array $data): void
    {
        $validationRules = [
            'chave' => ['string', 77, true],
            'txid' => ['string', 25, false],
            'valor' => ['string', 13, false],
            'nomeRecebedor' => ['string', 25, true],
            'cidade' => ['string', 15, true],
            'cep' => ['string', 8, false],
            'descricao' => ['string', 99, false],
            'pagamentoUnico' => ['boolean', null, false]
        ];

        foreach ($validationRules as $field => [$type, $maxLength, $isRequired]) {
            if (!isset($data[$field])) {
                if ($isRequired) {
                    $this->throwValidationError($field, 'campo_obrigatorio', "O campo '{$field}' é obrigatório.");
                }
                continue;
            }

            $value = $data[$field];

            if ($field === 'valor') {
                if (!is_string($value) || !preg_match('/^\d{1,10}\.\d{2}$/', $value)) {
                    $this->throwValidationError($field, 'formato_invalido', "O campo 'valor' deve ser uma string no formato 'X.XX' com até 10 dígitos na parte inteira.");
                }
            } elseif ($field === 'chave') {
                if (!$this->validatePixKey($value)) {
                    $this->throwValidationError($field, 'chave_pix_invalida', "O formato do campo 'chave' é inválido.");
                }
            } elseif ($field === 'txid') {
                if (preg_match('/[^a-zA-Z0-9]/', $value)) {
                    $this->throwValidationError($field, 'caracteres_invalidos', "O campo 'txid' deve conter apenas letras e números.");
                }
            } elseif (in_array($field, ['nomeRecebedor', 'cidade'])) {
                $normalizedValue = $this->sanitize($value);
                if (preg_match('/[^a-zA-Z0-9\s]/', $normalizedValue)) {
                    $this->throwValidationError($field, 'caracteres_invalidos', "O campo '{$field}' permite apenas letras, números e espaços.");
                }
            } elseif ($field === 'descricao') {
                $normalizedValue = $this->sanitize($value);
                if (preg_match('/[^a-zA-Z0-9\s_-]/', $normalizedValue)) {
                    $this->throwValidationError($field, 'caracteres_invalidos', "O campo '{$field}' permite apenas letras, números, espaços, hífen e underline.");
                }
            } elseif ($field === 'cep' && !preg_match('/^\d{8}$/', $value)) {
                $this->throwValidationError($field, 'formato_invalido', "O campo 'cep' deve conter exatamente 8 dígitos numéricos.");
            }

            $currentType = gettype($value);
            if (($type === 'string' && !is_string($value)) || ($type === 'boolean' && !is_bool($value))) {
                $this->throwValidationError($field, 'tipo_invalido', "O campo '{$field}' deve ser do tipo '{$type}', mas '{$currentType}' foi fornecido.");
            }

            if ($type === 'string' && strlen($value) > $maxLength) {
                $this->throwValidationError($field, 'tamanho_maximo_excedido', "O campo '{$field}' excede o tamanho máximo de {$maxLength} caracteres.");
            }
        }
    }

    private function validatePixKey(string $key): bool
    {
        if (filter_var($key, FILTER_VALIDATE_EMAIL))
            return true;
        if (preg_match('/^\d{11}$|^\d{14}$/', $key))
            return true;
        if (preg_match('/^\+\d+$/', $key))
            return true;
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $key))
            return true;
        return false;
    }

    private function throwValidationError(string $field, string $errorType, string $description): void
    {
        $errorPayload = [
            'error' => $errorType,
            'error_description' => $description,
            'property' => $field
        ];
        throw new EfiException('PIX', $errorPayload, 400, []);
    }

    private function formatValue(string $id, string $value): string
    {
        $size = str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT);
        return $id . $size . $value;
    }

    private function buildMerchantAccountInformation(array $data): string
    {
        $gui = $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'BR.GOV.BCB.PIX');
        $key = $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $data['chave']);
        $description = isset($data['descricao']) ? $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->sanitize($data['descricao'], '_-')) : '';
        return $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui . $key . $description);
    }

    private function buildOptionalFields(array $data): string
    {
        $optionalFields = '';
        if (isset($data['cep'])) {
            $optionalFields .= $this->formatValue(self::ID_MERCHANT_POSTAL_CODE, $this->sanitize($data['cep']));
        }
        return $optionalFields;
    }

    private function buildAdditionalDataField(array $data): string
    {
        // CORREÇÃO APLICADA: Usa o txid sanitizado se fornecido, ou '***' como padrão.
        $txidValue = isset($data['txid']) ? $this->sanitize($data['txid']) : '***';
        $txid = $this->formatValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $txidValue);
        return $this->formatValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
    }

    private function sanitize(string $text, string $extraChars = ''): string
    {
        $map = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'é' => 'e', 'ê' => 'e',
            'í' => 'i', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ú' => 'u', 'ç' => 'c',
            'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A', 'É' => 'E', 'Ê' => 'E',
            'Í' => 'I', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ú' => 'U', 'Ç' => 'C'
        ];

        $text = strtr($text, $map);
        return preg_replace('/[^a-zA-Z0-9\s' . preg_quote($extraChars, '/') . ']/', '', trim($text));
    }

    private function calculateCRC16(string $payload): string
    {
        $payload .= self::ID_CRC16 . '04';
        $polynomial = 0x1021;
        $result = 0xFFFF;
        for ($i = 0; $i < strlen($payload); $i++) {
            $result ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                $result = ($result << 1) ^ (($result & 0x8000) ? $polynomial : 0);
            }
        }
        return self::ID_CRC16 . '04' . strtoupper(str_pad(dechex($result & 0xFFFF), 4, '0', STR_PAD_LEFT));
    }
}