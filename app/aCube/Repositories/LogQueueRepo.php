<?php

/**
 * Created by PhpStorm.
 * User: LENOVOW8
 * Date: 29/09/2014
 * Time: 10:14 PM
 */

namespace aCube\Repositories;

use aCube\Entities\LogQueue;

class LogQueueRepo extends BaseRepo {

    /**
     * @return \Eloquent
     */
    public function getEntitie()
    {
        return new LogQueue();
    }

    /**
     * @return
     */
    public function logAgent($agent, $from, $to)
    {
        return $this->entitie
                    ->agent($agent)
                    ->time($from, $to);
    }

    /**
     * @return
     */
    public function logQueue($queue, $from, $to)
    {
        return $this->entitie
                    ->queue($queue)
                    ->time($from, $to);
    }

    /**
	 * @return
	 */
	public function logQueueAgent($queue, $agent, $from, $to)
	{
		return $this->entitie
                    ->queue($queue)
                    ->agent($agent)
                    ->time($from, $to);
	}

    /**
     * @return
     */
    public function logTime($from, $to)
    {
        return $this->entitie->time($from, $to);
    }

} 