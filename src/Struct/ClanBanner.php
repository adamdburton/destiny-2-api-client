<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;
use AdamDBurton\Destiny2ApiClient\Enum\GroupHomepage;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\MembershipOption;

class ClanBanner extends Struct
{
	protected $decalId = 'int';
	protected $decalColorId = 'int';
	protected $decalBackgroundColorId = 'int';
	protected $gonfalonId = 'int';
	protected $gonfalonColorId = 'int';
	protected $gonfalonDetailId = 'int';
	protected $gonfalonDetailColorId = 'int';
}