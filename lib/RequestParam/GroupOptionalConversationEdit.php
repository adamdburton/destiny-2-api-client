<?php
namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\RequestParam
 */
class GroupOptionalConversationEdit extends RequestParam
{
    protected $chatEnabled = 'bool';
    protected $chatName = 'string';
    protected $chatSecurity = ChatSecuritySetting::class;
}