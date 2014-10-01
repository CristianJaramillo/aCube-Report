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
		$this->responce->error = $error;
	}

	/**
	 * @param string $message
	 * @return void
	 */
	public function addMessage($message)
	{
		$this->responce->message = $message;
	}

	/**
	 * @param string $success
	 * @return void
	 */
	public function addSuccess($success)
	{
		$this->responce->success = $success;
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
				'queue'        => 'required',
				'queue_member' => 'required',
				'date_from'    => 'before:'.getDay(1).'|date_format:Y-m-d|required',
				'date_to'      => 'before:'.getDay(1).'|date_format:Y-m-d|required',
			);
	}	

	/**
	 * @return void
	 */
	public function execute()
	{
		$this->valid();
	}

	/**
	 * @return
	 */
	public function preparate()
	{
		if ($this->data['queue'] != 'all' && $this->data['queue_member'] != 'all') {
			$success = $this->repository->logQueueAgent(
					$this->data['queue'],
					$this->data['queue_member'],
					$this->data['date_from'], 
					$this->data['date_to']
				);
			$message = 'QueueAndMemeber';
		} elseif ($this->data['queue'] != 'all') {
			$success = $this->repository->logQueue(
					$this->data['queue'],
					$this->data['date_from'], 
					$this->data['date_to']
				);
			$message = 'Queue';
		} elseif ($this->data['queue_member'] != 'all') {
			$success = $this->repository->logAgent(
					$this->data['queue_member'],
					$this->data['date_from'], 
					$this->data['date_to']
				);
			$message = 'Memeber';
		} else {
			$success = $this->repository->logTime(
					$this->data['date_from'], 
					$this->data['date_to']
				);
			$message = 'Date';
		}

		$this->addMessage($message);

		return $this->preparateSuccess($success);

	}

	/**
	 * @param $success
	 * @return $success
	 */
	public function preparateSuccess($success)
	{
		return $success;
	}

	/**
	 * @return void
	 */
	public function valid()
	{

		if ($this->data['queue'] != 'all' && $this->data['queue_member'] != 'all')
		{
			$this->rules['queue_member'] .= '|exists:config_queue_members,membername,queue_name,'
							      		 .$this->data['queue_member'];
		} 

		if ($this->data['queue'] != 'all') {
        	$this->rules['queue'] .= '|exists:config_queues,name';	
        }

        if ($this->data['queue_member'] != 'all') {
        	$this->rules['queue_member'] .= '|exists:config_queue_members,membername';
        }

		$validation = \Validator::make($this->data, $this->rules);

		if ($validation->fails())
        {
            $this->addError($validation->messages());
        } else {
        	$this->setupDate($this->data['date_from'], $this->data['date_to']);
        	$this->addSuccess($this->preparate());
        }

	}

	/**
	 * @return void
	 */
	public function setupDate($from, $to)
	{
		if (strtotime($from) > strtotime($to)) {
			$this->data['date_from'] = $to;
			$this->data['date_to'] = $from;	
		}
	}

}