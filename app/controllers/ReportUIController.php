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

		echo "<pre>";
		print_r($response);
		echo "</pre>";
		dd();
		return $this->showReportUI();
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
