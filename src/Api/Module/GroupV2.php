<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Struct\ClanBanner;
use AdamDBurton\Destiny2ApiClient\Struct\GroupAction;
use AdamDBurton\Destiny2ApiClient\Struct\GroupEditAction;
use AdamDBurton\Destiny2ApiClient\Struct\GroupQuery;

class GroupV2 extends Module
{
	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getAvailableAvatars()
	{
		$this->assertHasAccessToken();

		return $this->apiClient->get('GroupV2/GetAvailableAvatars');
	}

	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getAvailableThemes()
	{
		$this->assertHasAccessToken();

		return $this->apiClient->get('GroupV2/GetAvailableThemes');
	}

	/**
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidBoolean
	 */
	public function setUserClanInviteSetting($membershipType, $allow)
	{
		$this->assertHasAccessToken();
		$this->assertIsMembershipType($membershipType);
		$this->assertIsBoolean($allow);

		return $this->apiClient->get('GroupV2/GetUserClanInviteSetting/' . $membershipType . '/' . ($allow ? 1 : 0));
	}

	/**
	 * @param $groupType
	 * @param $dateRange
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupDateRange
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getRecommendedGroups($groupType, $dateRange)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupType($groupType);
		$this->assertIsGroupDateRange($dateRange);

		return $this->apiClient->get('GroupV2/Recommended/' . $groupType . '/' . $dateRange);
	}

	/**
	 * @param GroupQuery $query
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function search(GroupQuery $query)
	{
		$this->assertHasAccessToken();

		return $this->apiClient->postAsJson('GroupV2/Search', $query->toArray());
	}

	/**
	 * @param $groupId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getGroup($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId);
	}

	/**
	 * @param $name
	 * @param $groupType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidString
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getGroupByName($name, $groupType)
	{
		$this->assertIsString($name);
		$this->assertIsGroupType($groupType);

		return $this->apiClient->get('GroupV2/Name/' . $name . '/' . $groupType);
	}

	/**
	 * @param $groupId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getGroupOptionalConversations($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/OptionalConversations');
	}

	/**
	 * @param GroupAction $action
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function createGroup(GroupAction $action)
	{
		$this->assertHasAccessToken();

		$this->apiClient->postAsJson('GroupV2/Create', $action->toArray());
	}

	/**
	 * @param $groupId
	 * @param GroupEditAction $action
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function editGroup($groupId, GroupEditAction $action)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		$this->apiClient->postAsJson('GroupV2/' . $groupId . '/Edit', $action->toArray());
	}

	/**
	 * @param $groupId
	 * @param ClanBanner $banner
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function editClanBanner($groupId, ClanBanner $banner)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		$this->apiClient->postAsJson('GroupV2/' . $groupId . '/EditClanBanner', $banner->toArray());
	}
}