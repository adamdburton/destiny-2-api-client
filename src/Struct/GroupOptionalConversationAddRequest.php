<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;

class GroupOptionalConversationAddRequest extends Struct
{
	protected $chatName = 'string';
	protected $chatSecurity = ChatSecuritySetting::class;
}