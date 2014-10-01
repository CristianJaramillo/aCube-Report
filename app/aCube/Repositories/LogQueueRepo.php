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
        $ids = $this->entitie->callids('agent', $agent, $from, $to);

        return $this->entitie
                        ->callIn($ids)
                        ->eventIn()
                        ->get();
    }

    /**
     * @return
     */
    public function logQueue($queue, $from, $to)
    {
        $ids = $this->entitie->callids('queuename', $queue, $from, $to);

        return $this->entitie
                        ->call$ids)
                        ->event()
                        ->get();
    }

    /**
	 * @return
	 */
	public function logQueueAgent($queue, $agent, $from, $to)
	{
        $ids = $this->entitie->queue($queue)->callids('agent', $agent, $from, $to);

		return $this->entitie
                        ->callIn($ids)
                        ->eventIn()
                        ->get();
	}

    /**
     * @return
     */
    public function logTime($from, $to)
    {
        return $this->entitie
                        ->eventIn()
                        ->dateBetween($from, $to)
                        ->get();
    }

} 