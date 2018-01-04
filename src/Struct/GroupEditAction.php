<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;
use AdamDBurton\Destiny2ApiClient\Enum\GroupHomepage;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\MembershipOption;
use AdamDBurton\Destiny2ApiClient\Enum\Publicity;

class GroupEditAction extends Struct
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