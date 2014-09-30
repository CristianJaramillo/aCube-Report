<?php
/**
 * Created by PhpStorm.
 * User: LENOVOW8
 * Date: 29/09/2014
 * Time: 10:02 PM
 */

namespace aCube\Repositories;


abstract class BaseRepo {

    /**
     *
     * @var \Eloquent
     */
    protected $entitie;

    /**
     *
     */
    public function __construct()
    {
       $this->entitie = $this->getEntitie();
    }

    /**
     * @return \Eloquent
     */
    abstract public function getEntitie();

} 