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
	 * @return \View
	 */
	public function showReportUI()
	{
		$queueRepo       = new ConfigQueueRepo();
		$queueMemberRepo = new ConfigQueueMemberRepo();

		$this->addParam([
				'queue'       => array('all' => '-- Queue --') + 
								 $queueRepo->listNames(),
				'queueMember' => array('all' => '-- Queue Members --') + 
								 $queueMemberRepo->listNames(),
			]);

		return $this->show();

	}

	/**
	 * @return \Response
	 */
	public function getReport()
	{

		$response = new ReportUIResponce(new LogQueueRepo(), Input::all());

		$response->execute();
		/*
		echo "<pre>";
		print_r($response);
		echo "</pre>";
	
		dd();
		*/

		return $this->showReportUI();
	}

}
