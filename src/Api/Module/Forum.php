<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
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
	 * @param ForumTopicQuickDate $quickDate
	 * @param ForumTopicCategoryFilter $categoryFilter
	 * @param string $locales
	 * @param string $tagString
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicCategoryFilter
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicQuickDate
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicSort
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
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
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicCategoryFilter
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicQuickDate
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicSort
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
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
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidForumPostSort
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
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

	public function
}