<?php

namespace Efi;

use Exception;

class Config
{
    /**
     * @var string Configuration file path for endpoints
     */
    private static $endpointsConfigFile = __DIR__ . '/Endpoints/Config.php';

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
        if (!file_exists(self::$endpointsConfigFile)) {
            throw new Exception('Arquivo de configuração não encontrado');
        }

        $config = include self::$endpointsConfigFile;

        if (!is_array($config) || !isset($config['APIs'])) {
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
        $conf['sandbox'] = isset($options['sandbox']) ? (bool)filter_var($options['sandbox'], FILTER_VALIDATE_BOOLEAN) : false;
        $conf['debug'] = isset($options['debug']) ? (bool)filter_var($options['debug'], FILTER_VALIDATE_BOOLEAN) : false;
        $conf['cache'] = isset($options['cache']) ? (bool)filter_var($options['cache'], FILTER_VALIDATE_BOOLEAN) : true;
        $conf['responseHeaders'] = isset($options['responseHeaders']) ? (bool)filter_var($options['responseHeaders'], FILTER_VALIDATE_BOOLEAN) : false;
        $conf['timeout'] = isset($options['timeout']) ? (float)$options['timeout'] : 30.0;
        $conf['clientId'] = (isset($options['client_id']) || isset($options['clientId'])) ? (string)($options['client_id'] ?? $options['clientId']) : null;
        $conf['clientSecret'] = (isset($options['client_secret']) || isset($options['clientSecret'])) ? (string)($options['client_secret'] ?? $options['clientSecret']) : null;
        $conf['partnerToken'] = (isset($options['partner_token']) || isset($options['partner-token']) || isset($options['partnerToken']))
            ? (string)($options['partner_token'] ?? $options['partner-token'] ?? $options['partnerToken'])
            : null;
        $conf['headers'] = $options['headers'] ?? null;
        $conf['baseUri'] = $options['url'] ?? null;
        $conf['api'] = $options['api'] ?? null;
        if ($conf['api'] !== 'CHARGES') {
            $conf['certificate'] = (isset($options['certificate']) || isset($options['pix_cert']))
                ? (string)($options['certificate'] ?? $options['pix_cert'])
                : null;
            $conf['pwdCertificate'] = isset($options['pwdCertificate']) ? (string)$options['pwdCertificate'] : '';
        }
        if ($conf['debug']) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }
        return $conf;
    }
}
