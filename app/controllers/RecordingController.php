<?php

use aCube\Responses\LogRecordingResponse;

class RecordingController extends BaseController {

	/**
	 * @var \Responce
	 */
	protected $response;

	/**
	 * @param aCube\Responses\LogRecordingResponse $response
	 * @return void
	 */
	public function __construct(LogRecordingResponse $response)
	{
		$this->response = $response;
	}

	/**
	 * @param $id
	 * @param $uniqueid
	 * @return \Response
	 * @throws aCube\Responses\ResponseException
	 */
	protected function make($id, $uniqueid)
	{
		return $this->response->makeFile($id, $uniqueid);
	}

	/**
	 * @param $id
	 * @param $uniqueid
	 * @return \Response
	 * @throws aCube\Responses\ResponseException
	 */
	protected function download($id, $uniqueid)
	{
		return $this->response->downloadFile($id, $uniqueid);
	}

}