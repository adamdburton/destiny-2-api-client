<?php

namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\GroupDateRange;
use AdamDBurton\Destiny2ApiClient\Enum\GroupMemberCountFilter;
use AdamDBurton\Destiny2ApiClient\Enum\GroupSortBy;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\Struct
 */
class GroupQuery extends RequestParam
{
    protected $name = 'string';
    protected $groupType = GroupType::class;
    protected $creationDate = GroupDateRange::class;
    protected $sortBy = GroupSortBy::class;
    protected $groupMemberCountFilter = GroupMemberCountFilter::class;
    protected $localeFilter = 'string';
    protected $tagText = 'string';
    protected $itemsPerPage = 'int';
    protected $currentPage = 'int';
    protected $requestContinuationToken = 'string';
}