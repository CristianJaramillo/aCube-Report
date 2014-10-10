<?php

use aCube\Responses\ConfigQueueResponse;

class QueueController extends BaseController {

	/**
	 * @var \Responce
	 */
	protected $response;

	/**
	 * @param aCube\Responses\ConfigQueueResponse $response
	 * @return void
	 */
	public function __construct(ConfigQueueResponse $response)
	{
		$this->response = $response;
	}

	/**
	 * @return array
	 */
	public function withMembers()
	{
		$response = $this->response->queueListsMembers();

		return $this->response->json($response);
	}

}