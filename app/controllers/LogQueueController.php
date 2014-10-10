<?php 

use aCube\Responses\LogQueueResponse;

class LogQueueController extends BaseController {

	/**
	 * @var $response
	 */
	protected $response;

	/**
	 * @return void
	 */
	public function __construct(LogQueueResponse $response)
	{
		$this->response = $response;
	}

	/**
	 * @return \Responce
	 */
	public function report()
	{
		$this->response->preparateData(Input::all());

		$this->response->isValid();

		return $this->response->jsonResponse();
	}
}