<?php

use aCube\Repositories\ConfigQueueRepo;
use aCube\Repositories\ConfigQueueMemberRepo;
use aCube\Repositories\LogQueueRepo;
use aCube\Responces\ReportUIResponce;

/**
 *
 */
class ReportUIController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Report UI Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * @return \Response
	 */
	public function getReport()
	{
		$response = new ReportUIResponce(new LogQueueRepo(), Input::all());

		$response->execute();
		
		return Response::json($response->getResponse());
	}

	/**
	 * @return json
	 */
	public function queueMembers()
	{
		$queueRepo = new ConfigQueueRepo();

		return Response::json($queueRepo->listQueuesAndMembers());
	}

}
