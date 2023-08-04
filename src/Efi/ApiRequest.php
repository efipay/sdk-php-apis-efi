<?php

namespace Efi;

use Efi\CacheRetriever;
use GuzzleHttp\Exception\ClientException;
use Efi\Exception\EfiException;

class ApiRequest
{
    private $auth;
    private $cache;
    private $request;
    private $options;
    private $cacheAccessToken;
    private $cacheAccessTokenExpires;

    /**
     * Constructor of the ApiRequest.
     * @param array $options - Array with configuration options and credentials.
     */
    public function __construct(?array $options = null)
    {
        $this->options = $options;
        $this->auth = new Auth($options);
        $this->request = new Request($options);
        $this->cache = new CacheRetriever();
    }

    /**
     * Sends an HTTP request.
     *
     * @param string $method The HTTP method.
     * @param string $route The URL route.
     * @param array $body The request body.
     * @return mixed The response data.
     * @throws EfiException If the request requires authorization.
     */
    public function send(string $method, string $route, array $body)
    {
        $hash = $this->options['api'] . $_SERVER['REMOTE_ADDR'] . substr($this->options['client_id'], -6);

        $this->cacheAccessToken = $this->cache->get(hash('sha512', "Efí-access_token_$hash"));
        $this->cacheAccessTokenExpires = $this->cache->get(hash('sha512', "Efí-access_token_expires_$hash"));

        if (
            (isset($this->options['cache']) ? !$this->options['cache'] : false) ||
            ($this->cacheAccessToken === null || $this->cacheAccessTokenExpires <= (time() - 5)
            )
        ) {
            $this->auth->authorize();
        } else {
            $this->auth->accessToken = $this->cacheAccessToken;
        }

        $composerData = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
        $requestTimeout = $this->options['timeout'] ?? 30.0;
        $requestHeaders = [
            'Authorization' =>  'Bearer ' . $this->auth->accessToken,
            'api-sdk' => 'efi-php-' . $composerData['version']
        ];

        if (isset($this->options['partner_token']) || isset($this->options['partner-token'])) {
            $requestHeaders['partner-token'] = $this->options['partner_token'] ?? $this->options['partner-token'];
        }

        try {
            return $this->request->send($method, $route, [
                'json' => $body,
                'timeout' => $requestTimeout,
                'headers' => $requestHeaders
            ]);
        } catch (ClientException $e) {
            throw new EfiException(
                $this->options['api'],
                [
                    'name' => $e->getResponse(),
                    'message' => $e->getResponse()->getBody()
                ],
                $e->getResponse()->getStatusCode()
            );
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
