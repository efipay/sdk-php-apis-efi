<?php

namespace Efi;

use Exception;

class Config
{
    /**
     * @var string Configuration file path for endpoints
     */
    private static $endpointsConfigFile = __DIR__ . '/config.json';

    /**
     * Set the endpoints configuration file.
     *
     * @param string $file The file path.
     */
    public static function setEndpointsConfigFile(string $file): void
    {
        self::$endpointsConfigFile = $file;
    }

    /**
     * Load the endpoint configurations from the file.
     *
     * @param string $property The parameter key.
     * @return mixed The value of the property.
     * @throws \Exception If there is an error loading the endpoint file.
     */
    public static function get(string $property)
    {
        $file = file_get_contents(self::$endpointsConfigFile);
        $config = json_decode($file, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erro ao carregar o arquivo de endpoints');
        }

        return $config[$property] ?? $config['APIs'][$property];
    }

    /**
     * Generate the configuration options.
     *
     * @param array $options The options array.
     * @return array The generated configuration.
     */
    public static function options(array $options): array
    {
        $conf['sandbox'] = (bool) isset($options['sandbox']) ? (bool) $options['sandbox'] : false;
        $conf['debug'] = (bool) isset($options['debug']) ? (bool) $options['debug'] : false;
        $conf['cache'] = (bool) isset($options['cache']) ? (bool) $options['cache'] : true;
        $conf['timeout'] = (float) isset($options['timeout']) ? $options['timeout'] : 30.0;
        $conf['clientId'] = (string) isset($options['client_id']) ? $options['client_id'] : null;
        $conf['clientSecret'] = (string) isset($options['client_secret']) ? $options['client_secret'] : null;
        $conf['headers'] = $options['headers'] ?? null;
        $conf['baseUri'] = $options['url'] ?? null;
        $conf['api'] = $options['api'];

        if ($conf['api'] !== 'CHARGES') {
            $conf['certificate'] = $options['certificate'] ?? $options['pix_cert'];
        }

        if ($conf['debug']) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }

        return $conf;
    }
}
