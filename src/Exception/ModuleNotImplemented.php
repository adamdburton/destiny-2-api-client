<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class ModuleNotImplemented extends Destiny2ApiException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s module has not yet been implemented.', $value));
	}
}