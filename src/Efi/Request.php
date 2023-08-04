<?php

namespace Efi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Efi\Exception\EfiException;

class Request
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
        $composerData = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
        $this->certifiedPath = $options['certified_path'] ?? null;

        $clientData = [
            'debug' => $this->config['debug'],
            'base_uri' => $this->config['baseUri'],
            'headers' => [
                'Content-Type' => 'application/json',
                'api-sdk' => 'php-' . $composerData['version']
            ]
        ];

        if (isset($options['partner_token']) || isset($options['partner-token'])) {
            $clientData['headers']['partner-token'] = $options['partner_token'] ?? $options['partner-token'];
        }

        $this->client = new Client($clientData);
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
        if ($this->certifiedPath) {
            $this->client->setDefaultOption('verify', $this->certifiedPath);
        }
        
        if (file_exists($certificate)) {
            $certPath = realpath($certificate);

            if (!$fileContents = file_get_contents($certPath)) {
                throw new EfiException($this->config['api'], ['nome' => 'forbidden', 'mensagem' => 'Não foi possível ler o arquivo de certificado'], 403);
            }

            if (pathinfo($certPath, PATHINFO_EXTENSION) === 'p12') {
                if (!openssl_pkcs12_read($fileContents, $certData, $password = '')) {
                    throw new EfiException($this->config['api'], ['nome' => 'forbidden', 'mensagem' => 'Não foi possível ler o arquivo de certificado p12'], 403);
                }

                $fileContents = $certData['cert'];
                $requestOptions['curl'] = [CURLOPT_SSLCERTTYPE => 'P12'];
            }

            if (!$publicKey = openssl_x509_parse($fileContents)) {
                throw new EfiException($this->config['api'], ['nome' => 'forbidden', 'mensagem' => 'Certificado inválido ou inativo'], 403);
            }

            $today = date("Y-m-d H:i:s");
            $validTo = date('Y-m-d H:i:s', $publicKey['validTo_time_t']);

            if ($validTo <= $today) {
                throw new EfiException($this->config['api'], ['nome' => 'forbidden', 'mensagem' => 'O certificado de autenticação expirou em ' . $validTo], 403);
            }

            return $certPath;
        } else {
            throw new EfiException($this->config['api'], ['nome' => 'forbidden', 'mensagem' => 'Certificado não encontrado'], 403);
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
            if (isset($this->config['certificate'])) {
                $requestOptions['cert'] = $this->verifyCertificate($this->config['certificate']);
            }

            if (isset($this->config['headers'])) {
                foreach ($this->config['headers'] as $key => $value) {
                    $requestOptions['headers'][$key] = $value;
                }
            }

            $response = $this->client->request($method, $route, $requestOptions);
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
        } catch (ClientException $e) {
            if (is_array(json_decode($e->getResponse()->getBody(), true)) && $e->getResponse()->getStatusCode() != 401) {
                throw new EfiException($this->config['api'], json_decode($e->getResponse()->getBody(), true), $e->getResponse()->getStatusCode());
            } else {
                throw new EfiException(
                    $this->config['api'],
                    [
                        'name' => $e->getResponse()->getReasonPhrase(),
                        'message' => $e->getResponse()->getBody()
                    ],
                    $e->getResponse()->getStatusCode()
                );
            }
        } catch (ServerException $se) {
            throw new EfiException($this->config['api'], $se->getResponse()->getBody(), $se->getResponse()->getStatusCode());
        }
    }

    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set(string $property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
