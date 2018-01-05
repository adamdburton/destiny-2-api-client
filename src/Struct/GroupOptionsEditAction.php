<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;
use AdamDBurton\Destiny2ApiClient\Enum\GroupHomepage;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\HostGuidedGamePermission;
use AdamDBurton\Destiny2ApiClient\Enum\MembershipOption;
use AdamDBurton\Destiny2ApiClient\Enum\RuntimeGroupMemberType;

class GroupOptionsEditAction extends Struct
{
	protected $InvitePermissionOverride = 'bool';
	protected $UpdateCulturePermissionOverride = 'bool';
	protected $HostGuidedGamePermissionOverride = HostGuidedGamePermission::class;
	protected $UpdateBannerPermissionOverride = 'bool';
	protected $JoinLevel = RuntimeGroupMemberType::class;
}