<?php

namespace Efi;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CacheRetriever
{
	private $cache;

	public function __construct()
	{
		$this->cache = new FilesystemAdapter('Efi');
	}

	public function get(string $key)
	{
		$cacheItem = $this->cache->getItem($key);

		if ($cacheItem->isHit()) {
			return $cacheItem->get();
		}

		return null;
	}

	public function set(string $key, $value, $ttl = null)
	{
		$cacheItem = $this->cache->getItem($key);
		$cacheItem->set($value);

		if ($ttl !== null) {
			$cacheItem->expiresAfter($ttl);
		}

		$this->cache->save($cacheItem);
	}
}
