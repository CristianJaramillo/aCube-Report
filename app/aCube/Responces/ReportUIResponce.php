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
	 * @return void
	 */
	public function addRules()
	{
		if (isset($this->data['queue']) && isset($this->data['queue_member'])) {
			if ($this->data['queue'] != 'all' && $this->data['queue_member'] != 'all')
			{
				$this->rules['queue'] .= '|exists:config_queues,name';
				$this->rules['queue_member'] .= '|exists:config_queue_members,membername'
											 .'|exists:config_queue_members,membername,queue_name,'
								      		 .$this->data['queue'];
			} else if ($this->data['queue'] != 'all') {
	        	$this->rules['queue'] .= '|exists:config_queues,name';	
	        } else if ($this->data['queue_member'] != 'all') {
	        	$this->rules['queue_member'] .= '|exists:config_queue_members,membername';
	        }
		}
	}

	/**
	 * @param  object $call
	 * @return array  $array
	 */
	public function arrayEnvent($call)
	{

		$row = array();

		switch ($call->event) {
			
			case 'ENTERQUEUE':
				$row = [
					'time' => $call->time,       // Hora de inicio.
					'queue' => $call->queuename, // Cola de atención.
					'phone' => $call->data2	     // Telefono
				];

			break;
			
			case 'CONNECT':
				$row = [
					'agent'    => $call->agent,
					'waiting'  => $call->data1,					
				];
			break;

			case 'TRANSFER':
				$row = [
					'transfer' => $call->data1,
					'waiting'  => $call->data3,
					'duration' => $call->data4,
				];
			break;

			case 'COMPLETECALLER':
							
				$row = [
					'agent'   => $call->agent,
					'waiting'  => $call->data1,
					'duration' => $call->data2,						
				];

			break;

			case 'COMPLETEAGENT':
							
				$row = [
					'agent'    => $call->agent,
					'waiting'  => $call->data1,
					'duration' => $call->data2,						
				];

			break;

			case 'EXITWITHTIMEOUT':
							
				$row = [
					'waiting'  => $call->data3,					
				];

			break;

			case 'EXITEMPTY':
				$row = [
					'waiting'  => $call->data3,					
				];
			break;

			case 'ABANDON':
				$row = [
					'waiting'  => $call->data3,
				];
			break;

		}

		return $row;
	}

	/**
	 * @return $this->date
	 */
	public function getResponse()
	{
		return $this->responce;
	}

	/**
	 * @return ArrayObject
	 */
	public function setResponce()
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
	 * @return
	 */
	public function getSuccess()
	{
		return $this->responce->success;
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

		if ($this->data['queue'] == 'all' && $this->data['queue_member'] == 'all') {
			
			$message = 'Date';

			$success = $this->repository->logDate(
							$this->data['date_from'], 
							$this->data['date_to']
						);

		} elseif ($this->data['queue'] != 'all' && $this->data['queue_member'] != 'all') {
			
			$message = 'QueueAndMemeber';

			$success = $this->repository->logQueueAgent(
							$this->data['queue'],
							$this->data['queue_member'],
							$this->data['date_from'], 
							$this->data['date_to']
						);
			
		} elseif ($this->data['queue'] != 'all') {
		
			$message = 'Queue';

			$success = $this->repository->logQueue(
					$this->data['queue'],
					$this->data['date_from'], 
					$this->data['date_to']
				);
		
		} else {
			
			$message = 'Error';
		
			$success = (object) array('invalid' => 'option');

		}

		$this->addMessage($message);

		return $this->preparateSuccess($success);

	}

	/**
	 * @param  object $logQueues
	 * @return array $success
	 */
	public function preparateSuccess($logQueues)
	{
		$success = array();

		foreach ($logQueues as $logQueue) {

			if (!isset($success[$logQueue->callid])) {
				$success[$logQueue->callid] = array();
			}

			$success[$logQueue->callid] += array($logQueue->event => $this->arrayEnvent($logQueue));

		}

		return $success;

	}

	/**
	 * @return void
	 */
	public function valid()
	{

		$this->addRules();

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