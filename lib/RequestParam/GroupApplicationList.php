<?php
namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\RequestParam
 */
class GroupApplicationList extends RequestParam
{
    protected $memberships = UserMembership::class . '[]';
    protected $message = 'string';
}