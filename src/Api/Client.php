<?php

namespace AdamDBurton\Destiny2ApiClient\Api;

use Http\Discovery\MessageFactoryDiscovery;

class Client
{
	protected $client;

	public function __construct()
	{
		$this->client = client = new HttpMethodsClient(
			HttpClientDiscovery::find(),
			MessageFactoryDiscovery::find()
		);
	}
}