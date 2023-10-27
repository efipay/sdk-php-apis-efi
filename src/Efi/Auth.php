<?php

namespace Efi;

use Exception;
use Efi\CacheRetriever;
use Efi\Config;
use Efi\Request;

class Auth extends BaseModel
{
    protected $accessToken;
    private $clientId;
    private $clientSecret;
    private $expires;
    private $config;
    private $options;
    private $request;
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
            throw new Exception('Credenciais Client_Id ou Client_Secret não encontradas');
        }

        $this->request = new Request($options);
        $this->cache = new CacheRetriever();

        $this->clientId = $this->config['clientId'];
        $this->clientSecret = $this->config['clientSecret'];
    }

    /**
     * Authorize the client and retrieve the access token.
     */
    public function authorize()
    {
        $endpoints = Config::get($this->options['api']);
        $requestTimeout = $this->options['timeout'];

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
        
        if ($this->options['cache']) {
            $this->expires = time() + $response['expires_in'];
            $session_expire = ($this->options['api'] === 'CHARGES') ? 600 : 3600;
            $this->cache->set(Utils::getCacheHash('access_token', $this->options['api'], $this->clientId), $this->accessToken, $session_expire);
            $this->cache->set(Utils::getCacheHash('access_token_expires', $this->options['api'], $this->clientId), $this->expires, $session_expire);
        }
    }
}
