<?php

namespace Efi;

use Exception;

/**
 * Utility class for various functions.
 */
class Utils
{
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

    public static function checkOpenSslExtension()
	{
		if (!extension_loaded('openssl')) {
            throw new Exception('A extensão OpenSSL não está habilitada no PHP ' . PHP_VERSION);
        }
	}
}
