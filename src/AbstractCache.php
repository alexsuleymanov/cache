<?php
namespace ASweb\Cache;

abstract class AbstractCache
{
	protected $Cache;
	
	const CLEANING_MODE_ALL              = 'all';
	const CLEANING_MODE_OLD              = 'old';
	const CLEANING_MODE_MATCHING_TAG     = 'matchingTag';

	public function load($id)
	{
		$c = $this->Cache->getItem($id);

		if ($c->isHit()) {
    		return $c->get();
		} else {
			return false;
		}
	}

    public function has($id)
    {
        return $this->Cache->hasItem($id);
	}
	
	public function save($data, $id = null, $tags = [])
	{
        $c = $this->Cache->getItem($id);

        if (!$c->isHit()) {
            $c->set($data);
            $this->Cache->save($c);
        }
    }

	public function delete($id)
	{
		$this->Cache->delete($id);
	}

	public function clean($tags = [])
	{
		if (empty($tags)) {
			$this->Cache->clear();
		} else {
			$this->Cache->invalidateTags($tags);
		}
	}
}