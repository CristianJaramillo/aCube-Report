<?php

/**
 * Created by PhpStorm.
 * User: LENOVOW8
 * Date: 29/09/2014
 * Time: 10:14 PM
 */

namespace aCube\Repositories;

use aCube\Entities\ConfigQueue;

class ConfigQueueRepo extends BaseRepo {

    /**
     * @return \Eloquent
     */
    public function getEntitie()
    {
        return new ConfigQueue();
    }

    /**
	 * @return
	 */
	public function listNames()
	{
		return $this->entitie->lists('name', 'name');
	}

} 