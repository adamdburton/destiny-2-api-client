<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Enum\ForumPostSort;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicSort;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumPostSort;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicSort;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class Forum extends Module
{
    /**
     * @param $page
     * @param $pageSize
     * @param $group
     * @param $sort
     * @param ForumTopicQuickDate $quickDate
     * @param ForumTopicCategoryFilter $categoryFilter
     * @param string $locales
     * @param string $tagString
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidForumTopicCategoryFilter
     * @throws InvalidForumTopicQuickDate
     * @throws InvalidForumTopicSort
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     * @internal param $membershipId
     */
    public function getTopicsPaged($page, $pageSize, $group, $sort, $quickDate, $categoryFilter, $locales = 'en', $tagString = '')
    {
        $this->assertIsForumTopicSort($sort);
        $this->assertIsForumTopicQuickDate($quickDate);
        $this->assertIsForumTopicCategoryFilter($categoryFilter);

        $sort = implode(',', ForumTopicSort::getEnumStringFor($sort));
        $quickDate = implode(',', ForumTopicQuickDate::getEnumStringFor($quickDate));
        $categoryFilter = implode(',', ForumTopicCategoryFilter::getEnumStringFor($categoryFilter));

        return $this->apiClient->get('Forum/GetTopicsPaged/' . $page . '/' . $pageSize . '/' . $group . '/' . $sort . '/' . $quickDate . '/' . $categoryFilter, [
            'locales' => $locales,
            'tagstring' => $tagString
        ]);
    }

    /**
     * @param $page
     * @param ForumTopicSort $sort
     * @param ForumTopicQuickDate $quickDate
     * @param ForumTopicCategoryFilter $categoryFilter
     * @param string $locales
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidForumTopicCategoryFilter
     * @throws InvalidForumTopicQuickDate
     * @throws InvalidForumTopicSort
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getCoreTopicsPaged($page, $sort, $quickDate, $categoryFilter, $locales = 'en')
    {
        $this->assertIsForumTopicSort($sort);
        $this->assertIsForumTopicQuickDate($quickDate);
        $this->assertIsForumTopicCategoryFilter($categoryFilter);

        $sort = implode(',', ForumTopicSort::getEnumStringFor($sort));
        $quickDate = implode(',', ForumTopicQuickDate::getEnumStringFor($quickDate));
        $categoryFilter = implode(',', ForumTopicCategoryFilter::getEnumStringFor($categoryFilter));

        return $this->apiClient->get('Forum/GetCoreTopicsPaged/' . $page . '/' . $sort . '/' . $quickDate . '/' . $categoryFilter, [
            'locales' => $locales
        ]);
    }

    /**
     * @param $parentPostId
     * @param $page
     * @param $pageSize
     * @param $replySize
     * @param $getParentPost
     * @param $rootThreadMode
     * @param ForumPostSort $sortMode
     * @param bool $showBanned
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidForumPostSort
     * @throws ApiKeyRequired
     */
    public function GetPostsThreadedPaged($parentPostId, $page, $pageSize, $replySize, $getParentPost, $rootThreadMode, $sortMode, $showBanned = false)
    {
        $this->assertIsForumPostSort($sortMode);

        $sortMode = implode(',', ForumPostSort::getEnumStringFor($sortMode));
        $showBanned = $showBanned ? 'true' : '';

        return $this->apiClient->get('Forum/GetPostsThreadedPaged/' . $parentPostId . '/' . $page . '/' . $pageSize . '/' . $replySize . '/' . $getParentPost . '/' . $rootThreadMode . '/' . $sortMode, [
            'showbanned' => $showBanned
        ]);
    }
}