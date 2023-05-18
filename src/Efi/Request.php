<?php

namespace Efi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Efi\Exception\EfiPayException;
use Efi\Exception\AuthorizationException;

class Request
{
    private $client;
    private $config;
    private $certifiedPath;

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

    private function verifyCertificate(string $certificate): string
    {
        if ($this->certifiedPath) {
            $this->client->setDefaultOption('verify', $this->certifiedPath);
        }

        if (isset($certificate)) {
            if (file_exists($certPath = realpath($certificate))) {
                if (!$fileContents = file_get_contents($certPath)) {
                    throw new EfiPayException(['name' => 'forbidden', 'message' => 'Unable to read the cert file'], 403);
                }

                if (strtolower(substr($certPath, -3)) === 'p12') {
                    if (!openssl_pkcs12_read($fileContents, $certData, $password = '')) {
                        throw new EfiPayException(['name' => 'forbidden', 'message' => 'Unable to read the cert file p12'], 403);
                    }

                    $fileContents = $certData['cert'];
                    $requestOptions['curl'] = [CURLOPT_SSLCERTTYPE => 'P12'];
                }

                if (!$publicKey = openssl_x509_parse($fileContents)) {
                    throw new EfiPayException(['name' => 'forbidden', 'message' => 'Certificate invalid'], 403);
                }

                $today = date("Y-m-d H:i:s");
                $validTo = date('Y-m-d H:i:s', $publicKey['validTo_time_t']);

                if ($validTo <= $today) {
                    throw new EfiPayException(['name' => 'forbidden', 'message' => 'Authentication certificate expired on ' . $validTo], 403);
                }

                return $certPath;
            } else {
                throw new EfiPayException(['name' => 'forbidden', 'message' => 'Certificate not found'], 403);
            }
        }
    }

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

            if (stristr($response->getHeader('Content-Type')[0], 'application/json')) {
                if ($decodedResponse = json_decode($response->getBody(), true)) {
                    return $decodedResponse;
                } else {
                    return ["code" => $response->getStatusCode()];
                }
            } else {
                return $response->getBody()->getContents();
            }
        } catch (ClientException $e) {
            if (is_array(json_decode($e->getResponse()->getBody(), true)) && $e->getResponse()->getStatusCode() != 401) {
                throw new EfiPayException(json_decode($e->getResponse()->getBody(), true), $e->getResponse()->getStatusCode());
            } else {
                throw new AuthorizationException(
                    $e->getResponse()->getStatusCode(),
                    $e->getResponse()->getReasonPhrase(),
                    $e->getResponse()->getBody()
                );
            }
        } catch (ServerException $se) {
            throw new EfiPayException($se->getResponse()->getBody(), $se->getResponse()->getStatusCode());
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
