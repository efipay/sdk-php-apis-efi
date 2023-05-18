<?php

namespace Efi;

use Exception;
use Efi\CacheRetriever;
use Efi\Config;
use Efi\Request;

class Auth
{
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $expires;
    private $config;
    private $options;
    private $request;
    private $certificate;
    private $cache;

    /**
     * Constructor of the Auth.
     * @param array $options - Array with configuration options and credentials.
     */
    public function __construct(array $options)
    {
        $this->options = $options;
        $this->config = Config::options($options);

        if (!isset($this->config['clientId']) || !isset($this->config['clientSecret'])) {
            throw new Exception('Client_Id or Client_Secret not found');
        }

        $this->request = new Request($options);
        $this->cache = new CacheRetriever();

        $this->clientId = $this->config['clientId'];
        $this->clientSecret = $this->config['clientSecret'];
        $this->certificate = $this->config['certificate'] ?? ($this->config['pix_cert'] ?? null);
    }

    /**
     * Authorize the client and retrieve the access token.
     */
    public function authorize()
    {
        $endpoints = Config::get($this->options['api']);
        $requestTimeout = (float) ($this->options['timeout'] ?? 30.0);

        $requestOptions = [
            'auth' => [$this->clientId, $this->clientSecret],
            'json' => ['grant_type' => 'client_credentials'],
            'timeout' => $requestTimeout,
        ];

        $response = $this->request->send(
            $endpoints['ENDPOINTS']['authorize']['method'],
            $endpoints['ENDPOINTS']['authorize']['route'],
            $requestOptions
        );

        $this->accessToken = $response['access_token'];
        $this->expires = time() + $response['expires_in'];

        $hash = $this->options['api'] . $_SERVER['REMOTE_ADDR'] . substr($this->clientId, -6);
        $session_expire = ($this->options['api'] === 'CHARGES') ? 600 : 3600;

        $this->cache->set(hash('sha512', "Efí-access_token_$hash"), $this->accessToken, $session_expire);
        $this->cache->set(hash('sha512', "Efí-access_token_expires_$hash"), $this->expires, $session_expire);
    }

    /**
     * Magic method to get the value of a property.
     *
     * @param string $property The name of the property.
     * @return mixed|null The value of the property, or null if it doesn't exist.
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * Magic method to set the value of a property.
     *
     * @param string $property The name of the property.
     * @param mixed $value The value to set.
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
