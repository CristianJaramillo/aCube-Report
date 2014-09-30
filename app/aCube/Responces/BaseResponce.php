<?php

namespace aCube\Responces;

use aCube\Repositories\BaseRepo;

/**
 * 
 */
abstract class BaseResponce
{
	/**
     * @var \Eloquent
     */
    protected $repository;

    /**
     * @var array
     */
    protected $data;

	/**
	 * @var ArrayObject
	 */
	protected $responce;

	/**
	 * @var array
	 */
	protected $rules;

	/**
	 * Construct BaseResponce
	 *
     * @param \Eloquent $repository
     * @param array $data
     * @return void
     */
    public function __construct(BaseRepo $repository, array $data)
    {
        $this->repository   = $repository;
        $this->data     = array_only($data, array_keys($this->getRules()));
		$this->responce = $this->getResponce();
		$this->rules    = $this->getRules();	
	}

	/**
	 * @return ArrayObject
	 */
	abstract public function getResponce();

	/**
	 * @return array
	 */
	abstract public function getRules();

}