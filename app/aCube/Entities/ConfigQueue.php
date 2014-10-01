<?php

/**
 * Created by Cristian Jaramillo.
 * User: @CristianJaramillo
 * Date: 29/09/2014
 * Time: 09:40 PM
 */

namespace aCube\Entities;


class ConfigQueue extends \Eloquent {

    /**
     * The database table used by the entitie.
     *
     * @var string
     */
    protected $table = 'config_queues';

    /**
     * @return
     */
    public function members()
    {
    	return $this->hasMany('aCube\Entities\ConfigQueueMember', 'queue_name', 'name');
    }

} 