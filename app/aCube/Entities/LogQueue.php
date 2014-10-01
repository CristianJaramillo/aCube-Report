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
     * @param $agent
     * @return $query
     */
    public function scopeAgent($query, $agent)
    {
    	return $query->WhereIn('agent', array(
                    $agent,
                    'NONE',
                )
            );
    }

    /**
     * @param $query
     * @return $query
     */
    public function scopeEvent($query)
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
        	)->orderBy('time', 'desc')->get();
    }

    /**
     * @param $query
     * @param $queue
     * @return $query
     */
    public function scopeQueue($query, $queue)
    {
    	return $query->Where('queuename', $queue);
    }

    /**
     * @param $query
     * @param $from
     * @param $to
     * @return $query
     */
    public function scopeTime($query, $from, $to)
    {
    	return $query->whereBetween('time', array(
        			$from.'  00:00:00',
        			$to.' 23:59:59'
        		)
        	)->event();
    }

} 