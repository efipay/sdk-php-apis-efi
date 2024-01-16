<?php

namespace Efi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Efi\Exception\EfiException;

class Request extends BaseModel
{
    private $client;
    private $config;
    private $certifiedPath;

    /**
     * Initializes a new instance of the Request class.
     * 
     * @param array|null $options The options to configure the Request.
     */
    public function __construct(array $options = null)
    {
        $this->config = Config::options($options);

        $clientData = $this->getClientData($options);
        $this->client = new Client($clientData);
    }

    /**
     * Prepares the data for configuring the Guzzle HTTP Client.
     *
     * @param array $options The options to configure the client.
     * @return array The configured data for the Guzzle HTTP Client.
     */
    private function getClientData(array $options): array
    {
        $composerData = Utils::getComposerData();

        $clientData = [
            'debug' => $this->config['debug'],
            'base_uri' => $this->config['baseUri'],
            'headers' => [
                'Content-Type' => 'application/json',
                'api-sdk' => 'efi-php-' . $composerData['version']
            ]
        ];

        if (isset($options['partnerToken'])) {
            $clientData['headers']['partner-token'] = $options['partnerToken'];
        }

        return $clientData;
    }

    /**
     * Verifies the certificate and returns the certificate path.
     *
     * @param string $certificate The certificate path.
     * @return string The path of the certificate.
     * @throws EfiException If the certificate is invalid or expired.
     */
    private function verifyCertificate(string $certificate): string
    {
        if (file_exists($certificate)) {
            $certPath = realpath($certificate);
            $fileContents = $this->readCertificateFile($certPath);

            $this->validateCertificate($fileContents, $certPath);

            return $certPath;
        } else {
            $this->throwEfiException('Certificado não encontrado', 403);
        }
    }

    /**
     * Reads the contents of the certificate file.
     *
     * @param string $certPath The path of the certificate file.
     * @return string The contents of the certificate file.
     * @throws EfiException If unable to read the certificate file.
     */

    private function readCertificateFile(string $certPath): string
    {
        $fileContents = file_get_contents($certPath);
        if (!$fileContents) {
            $this->throwEfiException('Não foi possível ler o arquivo de certificado', 403);
        }
        return $fileContents;
    }

    /**
     * Validates the certificate contents and checks for expiration.
     *
     * @param string $fileContents The contents of the certificate.
     * @param string $certPath The path of the certificate file.
     * @throws EfiException If the certificate is invalid or expired.
     */

    private function validateCertificate(string $fileContents, string $certPath): void
    {
        if (pathinfo($certPath, PATHINFO_EXTENSION) === 'p12') {
            $certData = $this->readP12Certificate($fileContents);
            $fileContents = $certData['cert'];
        }

        $publicKey = openssl_x509_parse($fileContents);
        if (!$publicKey) {
            $this->throwEfiException('Certificado inválido ou inativo', 403);
        }

        $this->checkCertificateEnviroment($publicKey['issuer']['CN']);
        $this->checkCertificateExpiration($publicKey['validTo_time_t']);
    }

    /**
     * Reads the contents of a P12 certificate file.
     *
     * @param string $fileContents The contents of the P12 certificate.
     * @return array The certificate data extracted from the P12 file.
     * @throws EfiException If unable to read the P12 certificate.
     */

    private function readP12Certificate(string $fileContents): array
    {
        if (!openssl_pkcs12_read($fileContents, $certData, $this->config['pwdCertificate'])) {
            $this->throwEfiException('Não foi possível ler o arquivo de certificado p12', 403);
        }
        return $certData;
    }

    /**
     * Checks if the certificate is valid to environment chosen.
     *
     * @param string $issuerCn The certificate issuer.
     * @throws EfiException If the certificate is not valid to environment chosed.
     */
    private function checkCertificateEnviroment(string $issuerCn): void
    {
        if ($this->config['sandbox'] === true && ($issuerCn === 'apis.sejaefi.com.br' || $issuerCn ===  'apis.efipay.com.br' || $issuerCn ===  'api-pix.gerencianet.com.br')) {
            $this->throwEfiException('Certificado de produção inválido para o ambiente escolhido [homologação].', 403);
        } elseif (!$this->config['sandbox'] && ($issuerCn === 'apis-h.sejaefi.com.br' || $issuerCn ===  'apis-h.efipay.com.br' || $issuerCn ===  'api-pix-h.gerencianet.com.br')) {
            $this->throwEfiException('Certificado de homologação inválido para o ambiente escolhido [produção].', 403);
        }
    }

    /**
     * Checks if the certificate has expired.
     *
     * @param string $validToTime Certificate validity data.
     * @throws EfiException If the certificate has expired.
     */
    private function checkCertificateExpiration(string $validToTime): void
    {
        $today = date("Y-m-d H:i:s");
        $validTo = date('Y-m-d H:i:s', $validToTime);
        if ($validTo <= $today) {
            $this->throwEfiException('O certificado de autenticação expirou em ' . $validTo, 403);
        }
    }

    /**
     * Sends an HTTP request.
     *
     * @param string $method The HTTP method.
     * @param string $route The URL route.
     * @param array $requestOptions The request options.
     * @return mixed The response data.
     * @throws EfiException If there is an EFI Pay specific error.
     */

    public function send(string $method, string $route, array $requestOptions)
    {
        try {
            $this->applyCertificateAndHeaders($requestOptions);

            $response = $this->client->request($method, $route, $requestOptions);
            return $this->processResponse($response);
        } catch (ClientException $e) {
            throw $this->handleClientException($e);
        } catch (ServerException $se) {
            $this->throwEfiException($se->getResponse()->getBody(), $se->getResponse()->getStatusCode());
        }
    }

    /**
     * Applies certificate and headers to the request options.
     *
     * @param array $requestOptions The request options to be modified.
     */

    private function applyCertificateAndHeaders(array &$requestOptions): void
    {
        if (isset($this->config['certificate'])) {
            $requestOptions['cert'] = [$this->verifyCertificate($this->config['certificate']), $this->config['pwdCertificate']];
        }

        if (isset($this->config['headers'])) {
            $requestOptions['headers'] = $this->mergeHeaders($requestOptions, $this->config['headers']);
        }
    }

    /**
     * Merges default headers with request-specific headers.
     *
     * @param array $requestOptions The request options containing headers.
     * @param array $defaultHeaders The default headers to be merged.
     * @return array The merged headers.
     */

    private function mergeHeaders(array $requestOptions, array $defaultHeaders): array
    {
        foreach ($defaultHeaders as $key => $value) {
            if (!isset($requestOptions['headers'][$key])) {
                $requestOptions['headers'][$key] = $value;
            }
        }
        return $requestOptions['headers'];
    }

    /**
     * Processes the HTTP response and returns the appropriate data.
     *
     * @param mixed $response The HTTP response object.
     * @return mixed The processed response data.
     */

    private function processResponse($response)
    {
        $headersResponse = $response->getHeader('Content-Type');

        if (isset($headersResponse[0]) && stristr(substr($headersResponse[0], 0, strpos($headersResponse[0], ';')), 'application/json')) {
            return json_decode($response->getBody(), true);
        } else {
            $bodyResponse = $response->getBody()->getContents();

            if ($bodyResponse) {
                return $bodyResponse;
            } else {
                return ["code" => $response->getStatusCode()];
            }
        }
    }

    /**
     * Handles the ClientException and creates an EFI exception.
     *
     * @param ClientException $e The caught ClientException.
     * @return EfiException The created EFI exception.
     */

    private function handleClientException(ClientException $e): EfiException
    {
        if (is_array(json_decode($e->getResponse()->getBody(), true))) {
            return new EfiException($this->config['api'], json_decode($e->getResponse()->getBody(), true), $e->getResponse()->getStatusCode());
        } else {
            return new EfiException(
                $this->config['api'],
                [
                    'error' => $e->getResponse()->getReasonPhrase(),
                    'error_description' => $e->getResponse()->getBody()
                ],
                $e->getResponse()->getStatusCode()
            );
        }
    }

    /**
     * Throws a common EfiException.
     *
     * @param string $message Error message.
     * @param int $statusCode HTTP status code.
     * @throws EfiException The EfiException.
     */
    private function throwEfiException(string $message, int $statusCode): void
    {
        if (is_array(json_decode($message, true))) {
            throw new EfiException($this->config['api'], json_decode($message, true), $statusCode);
        } else {
            throw new EfiException($this->config['api'], ['error' => 'forbidden', 'error_description' => $message], $statusCode);
        }
    }
}
