<?php

namespace aCube\Responces;

/**
 * 
 */
class ReportUIResponce extends BaseResponce
{

	/**
	 * @param string $error
	 * @return void
	 */
	public function addError($error)
	{
		$this->responce->error[] = $error;
	}

	/**
	 * @param string $message
	 * @return void
	 */
	public function addMessage($message)
	{
		$this->responce->message[] = $message;
	}

	/**
	 * @param string $success
	 * @return void
	 */
	public function addSuccess($success)
	{
		$this->responce->success[] = $success;
	}

	/**
	 * @return ArrayObject
	 */
	public function getResponce()
	{
		return (object) array(
				'error'   => array(),
				'message' => array(),
				'success' => array(),
			);
	}

	/**
	 * @return array
	 */
	public function getRules()
	{
		return array(
				'queue'        => 'exists:config_queues,name|required',
				'queue_member' => 'exists:config_queue_members,membername|required',
				'date_from'    => 'required',
				'date_up'      => 'required',
			);
	}	

}