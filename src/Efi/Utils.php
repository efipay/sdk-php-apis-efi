<?php

namespace Efi;

/**
 * Utility class for various functions.
 */
class Utils
{

    /**
     * Calculates the CRC16 checksum for a given string.
     *
     * @param string $str The input string.
     * @return string The CRC16 checksum.
     */
    public static function CRC16Checksum($str)
    {
        $crc = 0xFFFF;
        $strlen = strlen($str);

        for ($c = 0; $c < $strlen; $c++) {
            $crc ^= ord(substr($str, $c, 1)) << 8;

            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }

        $hex = $crc & 0xFFFF;
        $hex = dechex($hex);
        $hex = strtoupper($hex);

        return $hex;
    }

    /**
     * Generates a cache hash based on the provided parameters.
     *
     * @param string $prefix Prefix for the hash.
     * @param string $api API identifier.
     * @param string $clientId Client ID.
     * @return string The generated cache hash.
     */
    public static function getCacheHash(string $prefix, string $api, string $clientId): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'localhost';
        return hash('sha512', 'Efí-'. $prefix ."-". $api . $ip . substr($clientId, -6));
    }

    /**
     * Gets the data from the composer.json file and decodes it.
     *
     * @return array Parsed data from the composer.json file.
     */
    public static function getComposerData(): array
    {
        $composerJsonPath = __DIR__ . '/../../composer.json';
        return json_decode(file_get_contents($composerJsonPath), true);
    }
}
