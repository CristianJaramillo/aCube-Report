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
        $ids = $this->entitie
                        ->events()
                        ->callids('agent', $agent, $from, $to);

        if (is_object($ids)) {
            
            unset($ids);

            return (object) array();
        }

        return $this->entitie
                        ->calls($ids)
                        ->events()
                        ->date($from, $to)
                        ->get();
    }

    /**
     * @return
     */
    public function logQueue($queue, $from, $to)
    {
        $ids = $this->entitie
                        ->events()
                        ->callids('queuename', $queue, $from, $to);

        return $this->logQueues($ids, $from, $to);
    }

    /**
	 * @return
	 */
	public function logQueueAgent($queue, $agent, $from, $to)
	{
        $ids = $this->entitie
                        ->events()
                        ->queue($queue)
                        ->callids('agent', $agent, $from, $to);

        return $this->logQueues($ids, $from, $to);
    }

    /**
     * @param  $ids
     * @param  $from
     * @param  $to
     * @return
     */
    private function logQueues($ids, $from, $to)
    {
        if (is_array($ids) && !empty($ids)) {
            return $this->entitie
                        ->calls($ids)
                        ->events()
                        ->date($from, $to)
                        ->get();
        } else {
            return (object) array();
        }
    }

    /**
     * @return
     */
    public function logDate($from, $to)
    {
        return $this->entitie
                        ->events()
                        ->date($from, $to)
                        ->get();
    }

} 