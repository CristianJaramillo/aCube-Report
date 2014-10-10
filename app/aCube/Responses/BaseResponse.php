<?php namespace aCube\Responses;

abstract class BaseResponse {

	/**
	 * @var array
	 */
	protected $headers;

	/**
	 * @var aCube\Repositories\~
	 */
	protected $repository;

	/**
	 * @var array
	 */
	protected $rules;

	/**
	 * @return void
	 */
	public function __construct()
	{
		$this->headers = $this->getHeaders();
		$this->repository = $this->getRepository();
		$this->rules = $this->getRules();
	}

	/**
	 * @param string $pathToFile
	 * @param string $file
	 * @param array $headers 
	 * @return \Response
	 */
	public function download($pathToFile, $file = '', $headers = array())
	{
		return \Response::download($pathToFile, $file, $headers);
	}

	/**
	 * @return array
	 */
	public function getHeaders(){}

	/**
	 * @param $response
	 * @return \Response
	 */
	public function json($response)
	{
		return \Response::json($response);
	}

	/**
	 * @param mixed $content
	 * @param int $file
	 * @param array $headers 
	 * @return \Response
	 */
	protected function make($content, $status = 200, $headers = array())
	{
		return \Response::make($content, $status, $headers);
	}

	/**
	 * @return aCube\Repositories\~
	 */
	public function getRepository(){}

	/**
	 * @return array
	 */
	public function getRules(){}

	/**
	 * @param $key
	 * @param $value
	 * @return void
	 */
	public function setHeader($key, $value)
	{
		$this->headers[$key] = $value;
	}

}