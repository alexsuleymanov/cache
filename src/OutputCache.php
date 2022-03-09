<?php
namespace ASweb\Cache;

use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class OutputCache extends AbstractCache
{
	private $id;

	public function __construct($namespace, $lifetime, $dir)
	{
		$tagdir = $dir.'tags/';
		$cachefiles = new FilesystemAdapter($namespace, $lifetime, $dir);
		$cachetags = new FilesystemAdapter($namespace, $lifetime, $tagdir);
		$this->Cache = new TagAwareAdapter($cachefiles, $cachetags);
	}
	
	public function start($id)
	{
		if ($this->has($id)) {
			$this->id = $id;
			$buf = $this->load($id);
			echo $buf;
			return true;
		} else {
			$this->id = $id;
			ob_start();
			return false;
		}
		
	}

	public function end($tags = [])
	{
		$buf = ob_get_contents();
		ob_end_clean();		
		echo $buf;
		$this->save($buf, $this->id, $tags);
	}
}