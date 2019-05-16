<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Manifest;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Manifest
 */
class DefinitionNotFound extends ManifestException
{
	public function __construct($type, $hash)
	{
		parent::__construct(sprintf('The definition for %s with hash %s could not be found.', $type, $hash));
	}
}