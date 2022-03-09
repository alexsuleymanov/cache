<?php
namespace ASweb\Cache;

use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class MemCache extends AbstractCache
{
	public function __construct(string $namespace, int $lifetime, $dir = '')
	{
		if (MemcachedAdapter::isSupported()) {
			$this->Cache = new MemcachedAdapter(new \Memcached(), $namespace, $lifetime);
		} else {
			$tagdir = $dir.'tags/';
			$cachefiles = new FilesystemAdapter($namespace, $lifetime, $dir);
			$cachetags = new FilesystemAdapter($namespace, $lifetime, $tagdir);
			$this->Cache = new TagAwareAdapter($cachefiles, $cachetags);
		}

		if (!$this->Cache) {
			$tagdir = $dir.'tags/';
			$cachefiles = new FilesystemAdapter($namespace, $lifetime, $dir);
			$cachetags = new FilesystemAdapter($namespace, $lifetime, $tagdir);
			$this->Cache = new TagAwareAdapter($cachefiles, $cachetags);
		}
	}	
}