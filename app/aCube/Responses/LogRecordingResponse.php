<?php namespace aCube\Responses;

use aCube\Repositories\LogRecordingRepo;

class LogRecordingResponse extends BaseResponse {


	/**
	 * @param int $id
	 * @param int $uniqueid
	 * @return \Response
	 * @throws aCube\Responses\ResponseException
	 */
	public function downloadFile($id, $uniqueid)
	{
		$pathToFile = $this->getPathToFile($id, $uniqueid);

		$this->existsPathToFile($pathToFile);

		$file = $this->getNameFile($pathToFile);
		
		$this->setHeader("Content-length", filesize($pathToFile));
		$this->setHeader("Content-Disposition", "filename=\"{$file}\"");
		

		return $this->download($pathToFile, $file, $this->headers);
	}

	/**
	 * @return void
	 * @throws aCube\Responses\ResponseException
	 */
	public function existsPathToFile($path)
	{
		if (!\File::exists($path)) {
			throw new ResponseException('Not found file in: '.$path);
		}
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return array(
				"Cache-Control" => "max-age=".(60*60),
				"Content-Transfer-Encoding" => "chunked",
				"Content-Type" => "audio/wav",
				"Expires" => gmdate("D, d M Y H:i:s", time() + (60*60)) . " GMT",
				"X-Pad" => "avoid browser bug"
			);
	}

	/**
	 * 
	 */
	public function getNameFile($path)
	{
		$path = multiexplode(array("\\", "/"), $path);	
				
		return $path[count($path) - 1];
	}

	/**
	 * @param int $id
	 * @param int $uniqueid
	 * @return string
	 */
	public function getPathToFile($id, $uniqueid)
	{
		$path = $this->repository->getPathToFile($id, $uniqueid);

		if (is_array($path) && !empty($path)) {
			return $path[0];
		}

		unset($path);

		return '';
	}

	/**
	 * @return
	 */
	public function getRepository()
	{
		return new LogRecordingRepo();
	}


	/**
	 * @return array
	 */
	public function getRules()
	{
		return array(
				"id" => "required",
				"uniqueid" => "required",
			);
	}

	/**
	 * @param int $id
	 * @param int $uniqueid
	 * @return \Response
	 * @throws aCube\Responses\ResponseException
	 */
	public function makeFile($id, $uniqueid)
	{
		$pathToFile = $this->getPathToFile($id, $uniqueid);

		$this->existsPathToFile($pathToFile);

		$file = $this->getNameFile($pathToFile);

		$this->setHeader('Accept-Ranges', 'bytes');
		$this->setHeader("Content-length", filesize($pathToFile));
		$this->setHeader("Content-Disposition", " inline; filename=\"{$file}\"");

		$pathToFile = file_get_contents($pathToFile);

		return $this->make($pathToFile, 200, $this->headers);
	}


}