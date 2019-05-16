<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Manifest;

class InvalidManifestLanguage extends ManifestException
{
	public function __construct($language)
	{
		parent::__construct(sprintf('The %s language does not a Destiny manifest.', $language));
	}
}