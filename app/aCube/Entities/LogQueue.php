<?php

/**
 * Created by Cristian Jaramillo.
 * User: @CristianJaramillo
 * Date: 29/09/2014
 * Time: 09:40 PM
 */

namespace aCube\Entities;


class LogQueue extends \Eloquent {

    /**
     * The database table used by the entitie.
     *
     * @var string
     */
    protected $table = 'log_queue';

    /**
     * @param $query
     * @param $column
     * @param $value
     * @param $from
     * @param $to
     * @return array $query
     */
    public function scopeCallids($query, $column, $value, $from, $to)
    {
        return $query->where($column, $value)
                     ->date($from, $to)
                     ->groupBy('callid')
                     ->lists('callid');
    }

    /**
     * @param $query
     * @param $ids
     * @return $query
     */
    public function scopeCalls($query, $ids)
    {
        return $query->whereIn('callid', $ids);
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
                )->orderBy('time', 'desc');
    }

    /**
     * @param $query
     * @return $query
     */
    public function scopeEvents($query)
    {
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
    public function scopeQueue($query, $queue)
    {
    	return $query->where('queuename', $queue);
    }

} 