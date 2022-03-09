<?php
namespace ASweb\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

class FileCache extends AbstractCache
{
	public function __construct(string $namespace, int $lifetime, string $dir)
	{
		$tagdir = $dir.'tags/';
		$cachefiles = new FilesystemAdapter($namespace, $lifetime, $dir);
		$cachetags = new FilesystemAdapter($namespace, $lifetime, $tagdir);
		$this->Cache = new TagAwareAdapter($cachefiles, $cachetags);
	}
	
	public function save($data, $id = null, $tags = [])
	{
		$item = $this->Cache->getItem($id);
		$item->set($data);

		if (!empty($tags)) {
			$item->tag($tags);
		}
		$this->Cache->save($item);
		return true;
	}
}



