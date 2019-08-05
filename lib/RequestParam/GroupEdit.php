<?php

namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;
use AdamDBurton\Destiny2ApiClient\Enum\MembershipOption;
use AdamDBurton\Destiny2ApiClient\Enum\Publicity;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\RequestParam
 */
class GroupEdit extends RequestParam
{
    protected $name = 'string';
    protected $about = 'string';
    protected $motto = 'string';
    protected $theme = 'string';
    protected $avatarImageIndex = 'int';
    protected $tags = 'string';
    protected $isPublic = 'bool';
    protected $membershipOption = MembershipOption::class;
    protected $isPublicTopicAdminOnly = 'bool';
    protected $allowChat = 'bool';
    protected $chatSecurity = ChatSecuritySetting::class;
    protected $callsign = 'string';
    protected $locale = 'string';
    protected $enableInvitationMessagingForAdmins = 'bool';
    protected $defaultPublicity = Publicity::class;
}