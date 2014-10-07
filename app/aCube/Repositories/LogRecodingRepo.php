<?php

namespace aCube\Repositories;	

use aCube\Entitie\LogRecoding;

/**
 * 
 */
class LogRecodingRepo extends BaseRepo
{
	/**
	 * @return 
	 */
	public function getEntitie() 
	{
		return new LogRecoding();
	}

	/**
	 * @return string
	 */
	public function getRecoding()
	{
		
	}

}