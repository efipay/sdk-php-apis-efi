<?php

namespace Efi;

use Efi\Exception\EfiException;
use GuzzleHttp\Exception\ClientException;

class ApiRequest
{
    private Auth $auth;
    private CacheRetriever $cache;
    private Request $request;
    private array $options;
    private ?string $cacheAccessToken = null;
    private ?int $cacheAccessTokenExpires = null;

    /**
     * Initializes a new instance of the ApiRequest class.
     *
     * @param array|null $options The options to configure the ApiRequest.
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
     * @throws EfiException If there is an EFI specific error.
     */
    public function send(string $method, string $route, array $body)
    {
        $this->loadAccessTokenFromCache();

        if (!$this->isAccessTokenValid() || !$this->options['cache']) {
            $this->auth->authorize();
        }

        $requestTimeout = $this->options['timeout'] ?? 30.0;
        $requestHeaders = $this->buildRequestHeaders();

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

    /**
     * Loads the access token from cache if available.
     */
    private function loadAccessTokenFromCache(): void
    {
        $hash = $this->generateCacheHash();
        $this->cacheAccessToken = $this->cache->get(hash('sha512', "Efí-access_token_$hash"));
        $this->cacheAccessTokenExpires = $this->cache->get(hash('sha512', "Efí-access_token_expires_$hash"));
    }

    /**
     * Checks if the cached access token is valid.
     *
     * @return bool True if the access token is valid, otherwise false.
     */
    private function isAccessTokenValid(): bool
    {
        return $this->cacheAccessToken !== null && $this->cacheAccessTokenExpires > (time() - 5);
    }

    /**
     * Builds the headers for the HTTP request.
     *
     * @return array The headers for the HTTP request.
     */
    private function buildRequestHeaders(): array
    {
        $composerData = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
        $requestHeaders = [
            'Authorization' => 'Bearer ' . $this->auth->accessToken,
            'api-sdk' => 'efi-php-' . $composerData['version']
        ];

        if (isset($this->options['partner_token']) || isset($this->options['partner-token'])) {
            $requestHeaders['partner-token'] = $this->options['partner_token'] ?? $this->options['partner-token'];
        }

        return $requestHeaders;
    }

    /**
     * Generates a cache hash based on API, IP address, and client ID.
     *
     * @return string The generated cache hash.
     */
    private function generateCacheHash(): string
    {
        return $this->options['api'] . $_SERVER['REMOTE_ADDR'] . substr($this->options['client_id'], -6);
    }

    public function __get($property)
    {
        return $this->$property ?? null;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
