<?php namespace aCube\Repositories;

use aCube\Entities\LogRecording;

class LogRecordingRepo extends BaseRepo {

	/**
	 * @return aCube\Entities\LogRecoding
	 */
	public function getEntitie()
	{
		return new LogRecording();
	}

	/**
	 * @return string 
	 */
	public function getPathToFile($id, $uniqueid)
	{
		return $this->entitie->pathFile($id, $uniqueid);
	}

	/**
	 * @return $query
	 */
	public function listsIds($uniqueids)
	{
		return $this->entitie->listsIds($uniqueids)->get();
	}

}