<?php

namespace Efi;

use Exception;

class FileCacheRetriever
{
    private $cacheDir;

    /**
     * FileCacheRetriever constructor.
     *
     * @throws Exception If the cache directory cannot be created.
     */
    public function __construct()
    {
        $this->cacheDir = sys_get_temp_dir() . '/efi_cache';

        if (!is_dir($this->cacheDir) && !@mkdir($this->cacheDir, 0755, true)) {
            throw new Exception('Falha ao criar diretório de cache.');
        }

        $this->cleanExpiredCache();
    }

    /**
     * Generates the file path for a cache key.
     *
     * @param string $key The cache key.
     * @return string The file path.
     */
    private function getFilePath(string $key): string
    {
        return $this->cacheDir . '/' . hash('sha256', $key);
    }

    /**
     * Retrieves a value from the cache based on the provided key.
     *
     * @param string $key The cache key.
     * @return mixed|null The cached value or null if not found or expired.
     */
    public function get(string $key)
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return [];
        }

        $data = json_decode(file_get_contents($filePath), true);

        if ($data === null || ($data['expires'] && $data['expires'] < time())) {
            $this->delete($key);
            return [];
        }

        return $data['value'];
    }

    /**
     * Sets a value in the cache with the specified key, value, and time-to-live (TTL).
     *
     * @param string $key The cache key.
     * @param mixed $value The value to be cached.
     * @param int|null $ttl The time-to-live in seconds (optional).
     */
    public function set(string $key, $value, ?int $ttl = null): void
    {
        $filePath = $this->getFilePath($key);
        $data = [
            'value' => $value,
            'expires' => $ttl ? time() + $ttl : null,
        ];

        file_put_contents($filePath, json_encode($data), LOCK_EX);
        chmod($filePath, 0640);
    }

    /**
     * Checks if specified cache items exist in the cache.
     *
     * @param array $items An array of cache keys to check.
     * @return bool True if all specified cache keys exist and are not expired, false otherwise.
     */
    public function hasCache(array $items): bool
    {
        foreach ($items as $key) {
            $filePath = $this->getFilePath($key);

            if (!file_exists($filePath)) {
                return false;
            }

            $data = json_decode(file_get_contents($filePath), true);

            if ($data === null || ($data['expires'] && $data['expires'] < time())) {
                return false;
            }
        }

        return true;
    }

    /**
     * Clears all cached data.
     */
    public function clear(): void
    {
        foreach (glob($this->cacheDir . '/*') as $file) {
            unlink($file);
        }
    }

    /**
     * Deletes a specific cache item.
     *
     * @param string $key The cache key.
     */
    private function delete(string $key): void
    {
        $filePath = $this->getFilePath($key);

        if (file_exists($filePath) && !unlink($filePath)) {
            error_log("Failed to delete cache file: $filePath");
        }
    }

    /**
     * Cleans expired cache items.
     */
    private function cleanExpiredCache(): void
    {
        foreach (glob($this->cacheDir . '/*') as $file) {
            $data = json_decode(file_get_contents($file), true);

            if ($data === null || ($data['expires'] && $data['expires'] < time())) {
                unlink($file);
            }
        }
    }
}
