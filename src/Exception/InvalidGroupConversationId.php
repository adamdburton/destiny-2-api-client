<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidGroupConversationId extends Destiny2ApiException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid group conversation id.', $value));
	}
}