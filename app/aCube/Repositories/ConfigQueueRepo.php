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

    /**
     * @return
     */
    public function queuesAndMemebers()
    {
        return $this->entitie->with('members')->get();
    }

    /**
     * @return
     */
    public function listQueuesAndMembers()
    {
        $queues = array();

        foreach ($this->queuesAndMemebers() as $queue)
        {
            $aux = array();

            foreach ($queue->members as $member) {
                $aux[] = $member->membername;
            }

            $queues[$queue->name] = $aux;
    
        }

        return $queues;
    }

} 