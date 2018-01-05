<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;

class GroupOptionalConversationEditRequest extends Struct
{
	protected $chatEnabled = 'bool';
	protected $chatName = 'string';
	protected $chatSecurity = ChatSecuritySetting::class;
}