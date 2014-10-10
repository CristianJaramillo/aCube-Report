<?php namespace aCube\Responses;

use aCube\Repositories\ConfigQueueRepo;

class ConfigQueueResponse extends BaseResponse {

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return array();
	}

	/**
	 * @return aCube\Repositories\ConfigQueueRepo
	 */
	public function getRepository()
	{
		return new ConfigQueueRepo();
	}

	/**
	 * @return array
	 */
	public function getRules()
	{
		return array();
	}

	/**
	 * @return array
	 */
	public function queueListsMembers()
	{
		$response = array();

		$queues = $this->repository->queueWithMembers();

		foreach ($queues as $queue) {

			$memberName = array();
			
			foreach ($queue->members as $member) {
				$memberName[] = $member->membername;
			}

			$response[$queue->name] = $memberName;

		}

		return $response;
	}

}