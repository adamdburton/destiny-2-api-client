<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidManifestPath extends Destiny2ApiException
{
	public function __construct($path)
	{
		parent::__construct(sprintf('%s is not a valid path directory.', $path));
	}
}