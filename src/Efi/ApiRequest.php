<?php

namespace Efi;

use Efi\Exception\EfiException;
use GuzzleHttp\Exception\ClientException;

class ApiRequest extends BaseModel
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
        $this->options = Config::options($options);
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
        } else {
            $this->auth->accessToken = $this->cacheAccessToken;
        }

        $requestTimeout = $this->options['timeout'];
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
                    'error' => $e->getResponse(),
                    'error_description' => $e->getResponse()->getBody()
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
        $this->cacheAccessToken = $this->cache->get(Utils::getCacheHash('access_token', $this->options['api'], $this->options['clientId']));
        $this->cacheAccessTokenExpires = $this->cache->get(Utils::getCacheHash('access_token_expires', $this->options['api'], $this->options['clientId']));
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
        $composerData = Utils::getComposerData();
        $requestHeaders = [
            'Authorization' => 'Bearer ' . $this->auth->accessToken,
            'api-sdk' => 'efi-php-' . $composerData['version']
        ];

        if (isset($this->options['partnerToken'])) {
            $requestHeaders['partner-token'] = $this->options['partnerToken'] ?? $this->options['partner-token'];
        }

        return $requestHeaders;
    }
}
