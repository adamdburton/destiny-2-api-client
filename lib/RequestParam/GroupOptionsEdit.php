<?php
namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\HostGuidedGamePermission;
use AdamDBurton\Destiny2ApiClient\Enum\RuntimeGroupMemberType;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\RequestParam
 */
class GroupOptionsEdit extends RequestParam
{
    protected $InvitePermissionOverride = 'bool';
    protected $UpdateCulturePermissionOverride = 'bool';
    protected $HostGuidedGamePermissionOverride = HostGuidedGamePermission::class;
    protected $UpdateBannerPermissionOverride = 'bool';
    protected $JoinLevel = RuntimeGroupMemberType::class;
}