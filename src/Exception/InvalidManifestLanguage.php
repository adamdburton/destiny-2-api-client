<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidManifestLanguage extends Destiny2ApiException
{
	public function __construct($language)
	{
		parent::__construct(sprintf('The %s language does not a Destiny manifest.', $language));
	}
}