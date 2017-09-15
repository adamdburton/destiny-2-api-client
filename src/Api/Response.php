<?php

namespace AdamDBurton\Destiny2ApiClient\Api;

use Psr\Http\Message\ResponseInterface;

class Response
{
	private $response;

	public function __construct(ResponseInterface $response)
	{
		$this->response = $response;
	}

	public function getResponse()
	{
		return json_decode((string) $this->response->getBody());
	}

	public function getStatusCode()
	{
		return $this->response->getStatusCode();
	}
}