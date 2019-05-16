<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Enum\ForumPostSort;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicSort;

class Forum extends Module
{
    /**
     * @param $page
     * @param $pageSize
     * @param $group
     * @param $sort
     * @param $quickDate
     * @param $categoryFilter
     * @param string $locales
     * @param string $tagString
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getTopicsPaged($page, $pageSize, $group, $sort, $quickDate, $categoryFilter, $locales = 'en', $tagString = '')
    {
        $this->assertIsForumTopicSort($sort);
        $this->assertIsForumTopicQuickDate($quickDate);
        $this->assertIsForumTopicCategoryFilter($categoryFilter);

        $sort = implode(',', ForumTopicSort::getEnumStringFor($sort));
        $quickDate = implode(',', ForumTopicQuickDate::getEnumStringFor($quickDate));
        $categoryFilter = implode(',', ForumTopicCategoryFilter::getEnumStringFor($categoryFilter));

        return $this->request()
            ->endpoint('Forum/GetTopicsPaged/' . $page . '/' . $pageSize . '/' . $group . '/' . $sort . '/' . $quickDate . '/' . $categoryFilter)
            ->params([
                'locales' => $locales,
                'tagstring' => $tagString
            ])
            ->get();
    }

    /**
     * @param $page
     * @param $sort
     * @param $quickDate
     * @param $categoryFilter
     * @param string $locales
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getCoreTopicsPaged($page, $sort, $quickDate, $categoryFilter, $locales = 'en')
    {
        $this->assertIsForumTopicSort($sort);
        $this->assertIsForumTopicQuickDate($quickDate);
        $this->assertIsForumTopicCategoryFilter($categoryFilter);

        $sort = implode(',', ForumTopicSort::getEnumStringFor($sort));
        $quickDate = implode(',', ForumTopicQuickDate::getEnumStringFor($quickDate));
        $categoryFilter = implode(',', ForumTopicCategoryFilter::getEnumStringFor($categoryFilter));

        return $this->request()
            ->endpoint('Forum/GetCoreTopicsPaged/' . $page . '/' . $sort . '/' . $quickDate . '/' . $categoryFilter)
            ->params([
                'locales' => $locales
            ])
            ->get();
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
     * @throws HttpException
     */
    public function GetPostsThreadedPaged($parentPostId, $page, $pageSize, $replySize, $getParentPost, $rootThreadMode, $sortMode, $showBanned = false)
    {
        $this->assertIsForumPostSort($sortMode);

        $sortMode = implode(',', ForumPostSort::getEnumStringFor($sortMode));
        $showBanned = $showBanned ? 'true' : '';

        return $this->request()
            ->endpoint('Forum/GetPostsThreadedPaged/' . $parentPostId . '/' . $page . '/' . $pageSize . '/' . $replySize . '/' . $getParentPost . '/' . $rootThreadMode . '/' . $sortMode)
            ->params([
                'showbanned' => $showBanned
            ])
            ->get();
    }
}