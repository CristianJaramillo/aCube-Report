<?php namespace aCube\Repositories;

use aCube\Entities\ConfigQueue;

class ConfigQueueRepo extends BaseRepo {

	/**
	 * @return aCube\Entities\ConfigQueue
	 */
	public function getEntitie()
	{
		return new ConfigQueue();
	}

	/**
     * @return
     */
    public function queueWithMembers()
    {
        return $this->entitie->with('members')->get();
    }

}