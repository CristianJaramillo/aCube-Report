<?php namespace aCube\Repositories;

abstract class BaseRepo {

	/**
	 * @var aCube\Entitie\~
	 */
	protected $entitie;

	/**
	 * Constructor de BaseRepo
	 */
	public function __construct()
	{
		$this->entitie = $this->getEntitie();
	}

	/**
	 * @param int $id
	 * @return object
	 */
	public function find($id)
	{
		return $this->entitie->find($id);
	}

	/**
	 * @return aCube\Entitie\~
	 */
	public function getEntitie(){}

} 