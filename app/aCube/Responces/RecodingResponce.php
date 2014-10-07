<?php

namespace aCube\Responces;

use aCube\Repositories\LogRecodingRepo;

/**
 * 
 */
class RecodingResponce
{

	/**
	 * @var string
	 */
	protected $file;

	/**
	 * @var array
	 */
	protected $headers;

	/**
     * @var aCube\Repositories
     */
    protected $repository;

	/**
	 * @var \Responce
	 */
	protected $responce;

	/**
	 * @var string
	 */
	protected $prefix;

	/**
	 * @var array
	 */
	protected $rules;

	/**
	 *
	 */
	public function __construct($file) {
		$this->file = $file;
		$this->headers = $this->getHeaders();
		$this->repository = $this->getRepo();
		$this->rules = $this->getRules();
	}

	/**
	 * @return void
	 * @throws NotFoundHttpException;
	 */
	public function exits()
	{

	}

	/**
	 *
	 */
	public function getHeaders()
	{
		return array(
				"Cache-Control" => "no-cache",
				// "Content-Disposition" => "filename=\"$file\"",
				// "Content-length" => filesize($pathToFile),
				"Content-Transfer-Encoding" => "binary",
				"Content-Type" => "audio/wav, audio/x-wav, audio/wave, audio/x-pn-wav",
				"X-Pad" => "avoid browser bug"
			);
	}

	/**
	 * @return aCube\Repositories\LogRecondingRepo()
	 */
	public function getRepo()
	{
		return new LogRecodingRepo();
	}

	/**
	 * @return array 
	 */
	public function getRules()
	{
		return array(
				'file' => 'exits:log_recodings,file',
			);
	}

	/**
	 * @param string $type
	 * @param string $value
	 * @return void
	 */
	public function setHeader(string $type,string $value)
	{
		$this->headers[$type] = $value;
	}

	/**
	 * @param string $prefix
	 * @return void
	 */
	public function setPrefix(string $prefix)
	{
		$this->prefix = $prefix;
	}

}