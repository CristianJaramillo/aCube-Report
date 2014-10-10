<?php namespace aCube\Repositories;

use aCube\Entities\LogQueue;

class LogQueueRepo extends BaseRepo {

	/**
	 * @return aCube\Entities\LogQueue
	 */
	public function getEntitie()
	{
		return new LogQueue();
	}

	/**
	 * @return
	 */
	public function calls($callids, $from, $to, $event)
	{
		return $this->entitie
						->whereIn('callid', $callids)
						->date($from, $to)
						->events(NULL)
						->get();
	}

	/**
	 * @param  
	 * @return array
	 */
	public function callIds($event, $from, $to, $queue, $queue_member)
	{
		return $this->entitie
						->queue($queue)
						->agent($queue_member)
						->date($from, $to)
						->events($event)
						->groupBy('callid')
						->lists('callid');		
	}

}