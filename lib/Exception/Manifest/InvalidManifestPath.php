<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Manifest;

class InvalidManifestPath extends ManifestException
{
	public function __construct($path)
	{
		parent::__construct(sprintf('%s is not a valid directory.', $path));
	}
}