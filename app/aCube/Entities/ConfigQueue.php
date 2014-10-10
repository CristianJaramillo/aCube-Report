<?php namespace aCube\Entities;

class ConfigQueue extends \Eloquent {

    /**
     * The database table used by the entitie.
     *
     * @var string
     */
    protected $table = 'config_queues';

    /**
     * @return aCube\Entities\ConfigQueueMember
     */
    public function members()
    {
    	return $this->hasMany('aCube\Entities\ConfigQueueMember', 'queue_name', 'name');
    }

} 