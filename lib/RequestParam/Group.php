<?php
namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\ChatSecuritySetting;
use AdamDBurton\Destiny2ApiClient\Enum\GroupHomepage;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\MembershipOption;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\RequestParam
 */
class Group extends RequestParam
{
    protected $groupType = GroupType::class;
    protected $name = 'string';
    protected $about = 'string';
    protected $motto = 'string';
    protected $theme = 'string';
    protected $avatarImageIndex = 'int';
    protected $tags = 'string';
    protected $isPublic = 'bool';
    protected $membershipOption = MembershipOption::class;
    protected $isPublicTopicAdminOnly = 'bool';
    protected $isDefaultPostPublic = 'bool';
    protected $allowChat = 'bool';
    protected $isDefaultPostAlliance = 'bool';
    protected $chatSecurity = ChatSecuritySetting::class;
    protected $callsign = 'string';
    protected $locale = 'string';
    protected $homepage = GroupHomepage::class;
    protected $platformMembershipType = BungieMembershipType::class;
}