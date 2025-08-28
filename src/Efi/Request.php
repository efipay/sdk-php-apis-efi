<?php

namespace Efi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Efi\Exception\EfiException;
use Efi\Response;

class Request extends BaseModel
{
    private $client;
    private $config;
    private $cache;

    /**
     * Initializes a new instance of the Request class.
     * 
     * @param array|null $options The options to configure the Request.
     */
    public function __construct(?array $options = null)
    {
        $this->config = Config::options($options);
        $this->cache = new FileCacheRetriever();
        $clientData = $this->getClientData($options ?? []);
        $this->client = new Client($clientData);
    }

    /**
     * Prepares the data for configuring the Guzzle HTTP Client.
     *
     * @param array $options The options to configure the client.
     * @return array The configured data for the Guzzle HTTP Client.
     */
    private function getClientData(array $options = []): array
    {
        $composerData = Utils::getComposerData();

        $clientData = [
            'debug' => $this->config['debug'],
            'base_uri' => $this->config['baseUri'],
            'headers' => [
                'Content-Type' => 'application/json',
                'api-sdk' => 'efi-php-' . $composerData['version'],
                'Connection' => 'Keep-Alive'
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
     * @param string $certificate The certificate path or base64 content.
     * @return string The path of the certificate.
     * @throws EfiException If the certificate is invalid or expired.
     */
    private function verifyCertificate(string $certificate): string
    {
        // Check if the certificate is a file path with a valid extension.
        if (file_exists($certificate)) {
            $certPath = realpath($certificate);
            $extension = pathinfo($certPath, PATHINFO_EXTENSION);

            if (in_array($extension, ['p12', 'pem'])) {
                $fileContents = $this->readCertificateFile($certPath);
                $this->validateCertificate($fileContents, $certPath);
                return $certPath;
            }
        }

        // If not a file path, treat as base64 and manage with cache.
        if ($this->config['cache']) {
            $cacheKey = 'cert_path_' . hash('sha256', $certificate);
            $certPath = $this->cache->get($cacheKey);

            if ($certPath && file_exists($certPath)) {
                return $certPath; // Return cached certificate path.
            }
        }

        $fileContents = base64_decode($certificate, true);
        if ($fileContents === false) {
            $this->throwEfiException('Certificado fornecido não é um caminho de arquivo válido (.p12 ou .pem) nem uma string base64 válida.', 403, ['headers' => []]);
        }

        $certPath = tempnam(sys_get_temp_dir(), 'efi_cert_');
        if ($certPath === false || file_put_contents($certPath, $fileContents) === false) {
            $this->throwEfiException('Não foi possível criar o arquivo de certificado temporário do base64 em ' . $certPath, 500, ['headers' => []]);
        }

        chmod($certPath, 0640);
        $this->validateCertificate($fileContents, $certPath);

        if ($this->config['cache']) {
            $this->cache->set($cacheKey, $certPath, 3600); // Cache the new certificate path for 1 hour.
        }

        return $certPath;
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
            $this->throwEfiException('Não foi possível ler o arquivo de certificado', 403, ['headers' => []]);
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
        $certData = [];
        $pemContents = $fileContents;
        $isTempFile = strpos($certPath, sys_get_temp_dir()) === 0;
        $publicKey = null;

        // Check if the content is likely a PEM file.
        if (strpos($fileContents, 'BEGIN CERTIFICATE') !== false) {
            $publicKey = openssl_x509_parse($pemContents);

            $privateKeyEncrypted = strpos($fileContents, 'ENCRYPTED PRIVATE KEY') !== false;
            $passwordProvided = !empty($this->config['pwdCertificate']);
            $sourceType = $isTempFile ? "base64" : "PEM";

            if ($privateKeyEncrypted && !$passwordProvided) {
                if ($isTempFile)
                    unlink($certPath);
                $this->throwEfiException("A chave privada do certificado " . $sourceType . " está criptografada, mas nenhuma senha foi fornecida.", 403, ['headers' => []]);
            }

            if (!$privateKeyEncrypted && $passwordProvided) {
                if ($isTempFile)
                    unlink($certPath);
                $this->throwEfiException("Foi fornecida uma senha para uma chave privada de certificado " . $sourceType . " que não está criptografada.", 403, ['headers' => []]);
            }

            $privateKey = openssl_pkey_get_private($fileContents, $this->config['pwdCertificate']);
            if ($privateKey === false && $privateKeyEncrypted) {
                if ($isTempFile)
                    unlink($certPath);
                $this->throwEfiException("Não foi possível ler a chave privada do certificado " . $sourceType . ". A senha pode estar incorreta.", 403, ['headers' => []]);
            }
        } else {
            // Assume it's a P12, either from a file or base64.
            if (openssl_pkcs12_read($fileContents, $certData, $this->config['pwdCertificate'])) {
                $pemContents = $certData['cert'];
                $publicKey = openssl_x509_parse($pemContents);
            } else {
                // If reading the P12 fails, it's a password or format error.
                if ($isTempFile)
                    unlink($certPath);
                $sourceType = $isTempFile ? "base64" : "p12";
                $this->throwEfiException("Não foi possível ler o certificado. Se for um arquivo " . $sourceType . ", verifique a senha.", 403, ['headers' => []]);
            }
        }

        if (!$publicKey) {
            if ($isTempFile && !$this->config['cache']) { // Only unlink if it's a non-cached temp file.
                unlink($certPath);
            }
            $this->throwEfiException('Certificado inválido ou inativo. Verifique se o formato e o conteúdo do arquivo estão corretos.', 403, ['headers' => []]);
        }

        $this->checkCertificateEnviroment($publicKey['issuer']['CN']);
        $this->checkCertificateExpiration($publicKey['validTo_time_t']);
    }

    /**
     * Checks if the certificate is valid for the chosen environment.
     *
     * @param string $issuerCn The certificate issuer.
     * @throws EfiException If the certificate is not valid for the chosen environment.
     */
    private function checkCertificateEnviroment(string $issuerCn): void
    {
        if ($this->config['sandbox'] === true && ($issuerCn === 'apis.sejaefi.com.br' || $issuerCn ===  'apis.efipay.com.br' || $issuerCn ===  'api-pix.gerencianet.com.br')) {
            $this->throwEfiException('Certificado de produção inválido para o ambiente escolhido [homologação].', 403, ['headers' => []]);
        } elseif (!$this->config['sandbox'] && ($issuerCn === 'apis-h.sejaefi.com.br' || $issuerCn ===  'apis-h.efipay.com.br' || $issuerCn ===  'api-pix-h.gerencianet.com.br')) {
            $this->throwEfiException('Certificado de homologação inválido para o ambiente escolhido [produção].', 403, ['headers' => []]);
        }
    }

    /**
     * Checks if the certificate has expired.
     *
     * @param int $validToTime Certificate validity data.
     * @throws EfiException If the certificate has expired.
     */
    private function checkCertificateExpiration(int $validToTime): void
    {
        if ($validToTime <= time()) {
            $validTo = date('Y-m-d H:i:s', $validToTime);
            $this->throwEfiException('O certificado de autenticação expirou em ' . $validTo, 403, ['headers' => []]);
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
        if (!empty($this->config['debug']) && $this->config['debug'] === true) {
            echo '<br>[SDK] version: "' . ($requestOptions['api-sdk'] ?? $requestOptions['headers']['api-sdk']) . '" [REQUEST] method: "' . $method . '" url: "' . $this->config['baseUri'] . '" route: "' . $route . '"<br>';
        }
        try {
            $this->applyCertificateAndHeaders($requestOptions);
            $response = $this->client->request($method, $route, $requestOptions);
            return $this->processResponse($response);
        } catch (ClientException $e) {
            throw $this->handleClientException($e);
        } catch (ServerException $se) {
            $this->throwEfiException($se->getResponse()->getBody(), $se->getResponse()->getStatusCode(), $se->getResponse()->getHeaders());
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
            $requestOptions['headers'] = $this->mergeHeaders($requestOptions['headers'] ?? [], $this->config['headers']);
        }
    }

    /**
     * Merges default headers with request-specific headers.
     *
     * @param array $requestHeaders The request headers.
     * @param array $defaultHeaders The default headers to be merged.
     * @return array The merged headers.
     */
    private function mergeHeaders(array $requestHeaders, array $defaultHeaders): array
    {
        foreach ($defaultHeaders as $key => $value) {
            if (!isset($requestHeaders[$key])) {
                if ($key === 'x-skip-mtls-checking' && is_bool($value)) {
                    $requestHeaders[$key] = $value ? 'true' : 'false';
                } else {
                    $requestHeaders[$key] = $value;
                }
            }
        }
        return $requestHeaders;
    }

    /**
     * Processes the HTTP response and returns the appropriate data.
     *
     * @param \Psr\Http\Message\ResponseInterface $response The HTTP response object.
     * @return mixed The processed response data.
     */

    private function processResponse($response)
    {
        $headersResponse = $this->config['responseHeaders'] ? $response->getHeaders() : $response->getHeader('Content-Type');

        $contentType = !empty($headersResponse['Content-Type'][0]) ? $headersResponse['Content-Type'][0] : (!empty($headersResponse[0]) ? $headersResponse[0] : null);

        if (!empty($contentType) && stristr($contentType, 'application/json')) {
            $bodyResponse = json_decode($response->getBody(), true);
        } else {
            $bodyResponse = $response->getBody()->getContents();
        }

        if ($this->config['responseHeaders']) {
            return new Response($bodyResponse ?: ["code" => $response->getStatusCode()], $headersResponse);
        }

        return $bodyResponse ?: ["code" => $response->getStatusCode()];
    }


    /**
     * Handles the ClientException and creates an EFI exception.
     *
     * @param ClientException $e The caught ClientException.
     * @return EfiException The created EFI exception.
     */

    private function handleClientException(ClientException $e): EfiException
    {
        $responseHeaders = $e->getResponse()->getHeaders();
        if (is_array(json_decode($e->getResponse()->getBody(), true))) {
            return new EfiException($this->config['api'], json_decode($e->getResponse()->getBody(), true), $e->getResponse()->getStatusCode(), $responseHeaders);
        } else {
            return new EfiException(
                $this->config['api'],
                [
                    'error' => $e->getResponse()->getReasonPhrase(),
                    'error_description' => $e->getResponse()->getBody()
                ],
                $e->getResponse()->getStatusCode(),
                $responseHeaders
            );
        }
    }

    /**
     * Throws a common EfiException.
     *
     * @param string $message Error message.
     * @param int $statusCode HTTP status code.
     * @param array $headers Response headers.
     * @throws EfiException The EfiException.
     */
    private function throwEfiException(string $message, int $statusCode, array $headers): void
    {
        if (is_array(json_decode($message, true))) {
            throw new EfiException($this->config['api'], json_decode($message, true), $statusCode, $headers);
        } else {
            throw new EfiException($this->config['api'], ['error' => 'forbidden', 'error_description' => $message], $statusCode, $headers);
        }
    }
}
