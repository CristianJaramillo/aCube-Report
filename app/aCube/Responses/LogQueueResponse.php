<?php namespace aCube\Responses;

use aCube\Repositories\LogQueueRepo;
use aCube\Repositories\LogRecordingRepo;

class LogQueueResponse extends BaseResponse {

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var object
	 */
	protected $response;

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
					'agent'    => $call->agent,
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

		return $row + ['event' => $call->event];
	}

	/**
	 * @return void
	 */
	public function addRules()
	{
		if (isset($this->data['queue']) && isset($this->data['queue_member'])) {
			if ($this->data['queue'] != 'ALL' && $this->data['queue_member'] != 'ALL')
			{
				$this->rules['queue'] .= '|exists:config_queues,name';
				$this->rules['queue_member'] .= '|exists:config_queue_members,membername'
											 .'|exists:config_queue_members,membername,queue_name,'
								      		 .$this->data['queue'];
			} else if ($this->data['queue'] != 'ALL') {
	        	$this->rules['queue'] .= '|exists:config_queues,name';	
	        } else if ($this->data['queue_member'] != 'ALL') {
	        	$this->rules['queue_member'] .= '|exists:config_queue_members,membername';
	        }
		}
	}

	/**
	 * @return void
	 */
	public function execute()
	{
		$callIds = $this->listsIds($this->data);
		/*
		echo "<pre>";
		print_r($callIds);
		echo "</pre>";
		*/

		if (is_array($callIds) && !empty($callIds)) {

            $recodings = $this->listsRecordings($callIds);
        	
            $this->setMessage($recodings);
        	/*	
        	echo "<pre>";
			print_r($recodings);
			echo "</pre>";
			*/
			$calls = $this->preparateSuccess($this->listsCalls($callIds, $this->data));			
			/*
			echo "<pre>";
			print_r($calls);
			echo "</pre>";
			*/
			$this->setSuccess($calls);
        }
	}

	/**
	 * @param array
	 * @param array
	 * @return
	 */
	public function listsCalls($ids, $data)
	{
		extract($data, EXTR_OVERWRITE);
		return $this->repository->calls($ids, $date_from, $date_to, $event);
	}

	/**
	 * @return
	 */
	public function listsIds($data)
	{
		extract($data, EXTR_OVERWRITE);
		return $this->repository->callIds($event, $date_from, $date_to, $queue, $queue_member);
	}

	/**
	 * @return array
	 */
	public function listsRecordings($uniqueids)
	{
		$recordingsURL = array();

		$logRecording = new LogRecordingRepo();
		
		$logRecordings = $logRecording->listsIds($uniqueids);

		foreach ($logRecordings as $recording) {
			if (!isset($recordingsURL[$recording->uniqueid])) {
				$recordingsURL[$recording->uniqueid] = array();
			}			
			$recordingsURL[$recording->uniqueid][] = asset('recording/' . $recording->id . '/' . $recording->uniqueid); 
		}

		return $recordingsURL;
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return array();
	}

	/**
	 * @return ArrayObject
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return aCube\Repositories\LogQueueRepo
	 */
	public function getRepository()
	{
		return new LogQueueRepo();
	}

	/**
	 * @return array
	 */
	public function getRules()
	{
		return array(
				'queue'        => 'required',
				'queue_member' => 'required',
				'event'        => 'in:ALL,ABANDON,COMPLETECALL,COMPLETEAGENT,COMPLETECALLER,TRANSFER|required',
				'date_from'    => 'before:'.timeTo(1).'|date_format:Y-m-d|required',
				'date_to'      => 'before:'.timeTo(1).'|date_format:Y-m-d|required',
			);
	}

	/**
	 * @return void
	 */
	public function isValid()
	{
		$validation = \Validator::make($this->data, $this->rules);

		if ($validation->fails())
        {
            $this->setError($validation->messages());
        } else {
        	$this->data['event'] = $this->data['event'] == 'ALL' ? NULL : $this->data['event'];
        	$this->data['queue'] = $this->data['queue'] == 'ALL' ? NULL : $this->data['queue'];
        	$this->data['queue_member'] = $this->data['queue_member'] == 'ALL' ? NULL : $this->data['queue_member'];
        	$this->orderDate($this->data['date_from'], $this->data['date_to']);
        	$this->execute();
        }

	}

	/**
	 * @return \Response
	 */
	public function jsonResponse()
	{
		return $this->json($this->response);
	}

	/**
	 * @return void
	 */
	private function orderDate($from, $to)
	{
		if (strtotime($from) > strtotime($to)) {
			$this->data['date_from'] = $to;
			$this->data['date_to'] = $from;	
		}
	}

	/**
	 * @param array
	 * @return void
	 */
	public function preparateData($data)
	{
		$this->setResponse();
		$this->setData($data, $this->rules);
		$this->addRules();
	}

	/**
	 * @param  object $logQueues
	 * @return array $success
	 */
	public function preparateSuccess($logQueues)
	{
		$success = array();

		// Recorre todos los registros obtenidos
		foreach ($logQueues as $logQueue) {

			if (!isset($success[$logQueue->callid])) {
				$success[$logQueue->callid] = array();
			}

			array_unshift($success[$logQueue->callid], $this->arrayEnvent($logQueue));

		}

		return $success;

	}

	/**
	 * @param array
	 * @return void
	 */
	public function setData($data, $keys)
	{
		$this->data = array_only($data, array_keys($keys));
	}

	/**
	 * @param string $error
	 * @return void
	 */
	public function setError($error)
	{
		$this->response->error = $error;
	}

	/**
	 * @param string $message
	 * @return void
	 */
	public function setMessage($message)
	{
		$this->response->message = $message;
	}

	/**
	 *
	 */
	public function setResponse()
	{
		$this->response = (object) array(
				'error'   => array(),
				'message' => array(),
				'success' => array(),
			);
	}

	/**
	 * @param string $success
	 * @return void
	 */
	public function setSuccess($success)
	{
		$this->response->success = $success;
	}

}