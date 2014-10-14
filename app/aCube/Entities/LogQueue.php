<?php namespace aCube\Entities;

class LogQueue extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'log_queue';

	/**
     * @return aCube\Entities\ConfigQueueMember
     */
    public function recodings()
    {
    	return $this->hasMany('aCube\Entities\ConfigQueueMember', 'uniqueid', 'callid');
    }

    /**
     * @param $query
     * @param $agent
     * @param $query
     */
    public function scopeAgent($query, $agent = NULL)
    {
        if ($agent == NULL || empty($agent) || !is_string($agent)) {
            return $query;
        }

        return $query->where('agent', $agent);
    }

    /**
     * @param $query
     * @param $from
     * @param $to
     * @return $query
     */
    public function scopeDate($query, $from, $to)
    {
        return $query->whereBetween('time', array(
                        $from.'  00:00:00',
                        $to.' 23:59:59'
                     )
                )->orderBy('id', 'desc')->orderBy('time', 'desc');
    }

    /**
     * @param $query
     * @return $query
     */
    public function scopeEvents($query, $event = NULL)
    {

        if (!is_null($event)) {
            if ($event == 'COMPLETECALL') {
                return $query->whereIn('event', array('COMPLETEAGENT', 'COMPLETECALLER'));
            } else {
                return $query->where('event', $event);
            }
        }

        return $query->whereIn('event', array(
                    'ENTERQUEUE',
                    'CONNECT',
                    'TRANSFER',
                    'COMPLETECALLER',
                    'COMPLETEAGENT',
                    'EXITWITHTIMEOUT',
                    'EXITEMPTY',
                    'ABANDON',
                )
            );
    }

    /**
     * @param $query
     * @param $queue
     * @return $query
     */
    public function scopeQueue($query, $queue = NULL)
    {
        if ($queue == NULL || empty($queue) || !is_string($queue)) {
            return $query;
        }

        return $query->where('queuename', $queue);
    }

}