<?php

namespace AdamDBurton\Destiny2ApiClient\Api;

use Psr\Http\Message\ResponseInterface;

class Response
{
	/**
	 * @var ResponseInterface $response
	 */
	private $response;

	/**
	 * @var \stdClass $json
	 */
	private $json;

	/**
	 * Response constructor.
	 * @param ResponseInterface $response
	 */
	public function __construct(ResponseInterface $response)
	{
		$this->response = $response;
		$this->json = json_decode((string) $response->getBody());

		if(isset($this->json->Response))
		{
			$this->json = $this->json->Response;
		}
	}

	/**
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->getResponse()->getStatusCode() === 200;
	}

	/**
	 * @return \stdClass|\stdClass[]
	 */
	public function getData()
	{
		return $this->json;
	}

	/**
	 * @return ResponseInterface
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->response->getStatusCode();
	}

	/**
	 * @return \string[][]
	 */
	public function getHeaders()
	{
		return $this->response->getHeaders();
	}
}