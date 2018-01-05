<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Api\Response;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidBoolean;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupDateRange;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidString;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Struct\ClanBanner;
use AdamDBurton\Destiny2ApiClient\Struct\GroupAction;
use AdamDBurton\Destiny2ApiClient\Struct\GroupBanRequest;
use AdamDBurton\Destiny2ApiClient\Struct\GroupEditAction;
use AdamDBurton\Destiny2ApiClient\Struct\GroupQuery;

class GroupV2 extends Module
{
	/**
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getAvailableAvatars()
	{
		$this->assertHasAccessToken();

		return $this->apiClient->get('GroupV2/GetAvailableAvatars');
	}

	/**
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getAvailableThemes()
	{
		$this->assertHasAccessToken();

		return $this->apiClient->get('GroupV2/GetAvailableThemes');
	}

	/**
	 * @param $membershipType
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidMembershipType
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws InvalidBoolean
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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupDateRange
	 * @throws InvalidGroupType
	 * @throws ResourceNotFound
	 * @throws Unauthorized
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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function search(GroupQuery $query)
	{
		$this->assertHasAccessToken();

		return $this->apiClient->postAsJson('GroupV2/Search', $query->toArray());
	}

	/**
	 * @param $groupId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getGroup($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId);
	}

	/**
	 * @param $name
	 * @param $groupType
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupType
	 * @throws InvalidString
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getGroupByName($name, $groupType)
	{
		$this->assertIsString($name);
		$this->assertIsGroupType($groupType);

		return $this->apiClient->get('GroupV2/Name/' . $name . '/' . $groupType);
	}

	/**
	 * @param $groupId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getGroupOptionalConversations($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/OptionalConversations');
	}

	/**
	 * @param GroupAction $action
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function createGroup(GroupAction $action)
	{
		$this->assertHasAccessToken();

		$this->apiClient->postAsJson('GroupV2/Create', $action->toArray());
	}

	/**
	 * @param $groupId
	 * @param GroupEditAction $action
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
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
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function editClanBanner($groupId, ClanBanner $banner)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		$this->apiClient->postAsJson('GroupV2/' . $groupId . '/EditClanBanner', $banner->toArray());
	}

	/**
	 * @param $groupId
	 * @param GroupOptionsEditAction $action
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function editFounderOptions($groupId, GroupOptionsEditAction $action)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		$this->apiClient->postAsJson('GroupV2/' . $groupId . '/EditFounderOptions', $action->toArray());
	}

	/**
	 * @param $groupId
	 * @param GroupOptionalConversationAddRequest $request
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function addOptionalConversation($groupId, GroupOptionalConversationAddRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		$this->apiClient->postAsJson('GroupV2/' . $groupId . '/OptionalConversations/Add', $request->toArray());
	}

	/**
	 * @param $groupId
	 * @param $conversationId
	 * @param GroupOptionalConversationEditRequest $request
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function editOptionalConversation($groupId, $conversationId, GroupOptionalConversationEditRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsGroupConversationId($conversationId);

		$this->apiClient->postAsJson('GroupV2/' . $groupId . '/OptionalConversations/Edit/' . $conversationId, $request->toArray());
	}

	/**
	 * @param $groupId
	 * @param $currentPage
	 * @param $memberType
	 * @param $nameSearch
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getMembersOfGroup($groupId, $currentPage, $memberType, $nameSearch)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/Members', [ 'currentPage' => $currentPage, 'memberType' => $memberType, 'nameSearch' => $nameSearch ]);
	}

	/**
	 * @param $groupId
	 * @param $currentPage
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getAdminsAndFounderOfGroup($groupId, $currentPage)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/AdminsAndFounder', [ 'currentPage' => $currentPage ]);
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @param $membershipId
	 * @param $groupMemberType
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws InvalidMembershipType
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws InvalidMembershipId
	 */
	public function EditGroupMembership($groupId, $membershipType, $membershipId, $groupMemberType)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipType($membershipType);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsGroupMemberType($groupMemberType);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/' . $membershipType . '/' . $membershipId . '/SetMembershipType/' . $groupMemberType);
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @param $membershipId
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws InvalidMembershipType
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws InvalidMembershipId
	 */
	public function kickMember($groupId, $membershipType, $membershipId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipType($membershipType);
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/' . $membershipType . '/' . $membershipId . '/Kick');
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @param $membershipId
	 * @param GroupBanRequest $request
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws InvalidMembershipType
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws InvalidMembershipId
	 */
	public function banMember($groupId, $membershipType, $membershipId, GroupBanRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipType($membershipType);
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/' . $membershipType . '/' . $membershipId . '/Ban', $request->toArray());
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @param $membershipId
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws InvalidMembershipId
	 * @throws InvalidMembershipType
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function unbanMember($groupId, $membershipType, $membershipId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipType($membershipType);
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/' . $membershipType . '/' . $membershipId . '/Unban');
	}

	/**
	 * @param $groupId
	 * @param $currentPage
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getBannedMembersOfGroup($groupId, $currentPage)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/Banned', [
			'currentpage' => $currentPage
		]);
	}
}