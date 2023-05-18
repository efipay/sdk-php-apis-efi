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
            throw new Exception('Error loading endpoint file');
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
        $conf = [
            'sandbox' => $options['sandbox'] ?? false,
            'debug' => $options['debug'] ?? false,
        ];

        if ($conf['debug']) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }

        $conf['clientId'] = $options['client_id'] ?? null;
        $conf['clientSecret'] = $options['client_secret'] ?? null;
        $conf['timeout'] = $options['timeout'] ?? null;
        $conf['headers'] = $options['headers'] ?? null;
        $conf['baseUri'] = $options['url'] ?? null;

        if ($options['api'] !== 'CHARGES') {
            $conf['certificate'] = $options['certificate'] ?? $options['pix_cert'];
        }

        return $conf;
    }
}
