<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Api\Response;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\GroupDateRange;
use AdamDBurton\Destiny2ApiClient\Enum\GroupsForMemberFilter;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidBoolean;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidString;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Struct\ClanBanner;
use AdamDBurton\Destiny2ApiClient\Struct\GroupAction;
use AdamDBurton\Destiny2ApiClient\Struct\GroupApplicationListRequest;
use AdamDBurton\Destiny2ApiClient\Struct\GroupApplicationRequest;
use AdamDBurton\Destiny2ApiClient\Struct\GroupBanRequest;
use AdamDBurton\Destiny2ApiClient\Struct\GroupEditAction;
use AdamDBurton\Destiny2ApiClient\Struct\GroupOptionalConversationAddRequest;
use AdamDBurton\Destiny2ApiClient\Struct\GroupOptionalConversationEditRequest;
use AdamDBurton\Destiny2ApiClient\Struct\GroupOptionsEditAction;
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
	 * @param $allow
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidBoolean
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function setUserClanInviteSetting($membershipType, $allow)
	{
		$this->assertHasAccessToken();
		$this->assertIsBoolean($allow);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('GroupV2/GetUserClanInviteSetting/' . $membershipType . '/' . ($allow ? 1 : 0));
	}

	/**
	 * @param $groupType
	 * @param $dateRange
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function getRecommendedGroups($groupType, $dateRange)
	{
		$this->assertHasAccessToken();
		$this->assertIsEnum($groupType, GroupType::class);
		$this->assertIsEnum($dateRange, GroupDateRange::class);

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
	 * @throws InvalidString
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function getGroupByName($name, $groupType)
	{
		$this->assertIsString($name);
		$this->assertIsEnum($groupType, GroupType::class);

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
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupConversationId
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
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function editGroupMembership($groupId, $membershipType, $membershipId, $groupMemberType)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function kickMember($groupId, $membershipType, $membershipId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function banMember($groupId, $membershipType, $membershipId, GroupBanRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function unbanMember($groupId, $membershipType, $membershipId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function abdicateFoundership($groupId, $membershipType, $membershipId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Admin/AbdicateFoundership/' . $membershipType . '/' . $membershipId);
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function requestGroupMembership($groupId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/Apply/' . $membershipType);
	}

	/**
	 * @param $groupId
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getPendingMemberships($groupId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/Members/Pending');
	}

	/**
	 * @param $groupId
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getInvitedIndividuals($groupId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('GroupV2/' . $groupId . '/Members/InvitedIndividuals');
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function rescindGroupMembership($groupId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/Rescind/' . $membershipType);
	}

	/**
	 * @param $groupId
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function approveAllPending($groupId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/ApproveAll');
	}

	/**
	 * @param $groupId
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function denyAllPending($groupId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/DenyAll');
	}

	/**
	 * @param $groupId
	 * @param GroupApplicationListRequest $request
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function approvePendingForList($groupId, GroupApplicationListRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/ApproveList', $request->toArray());
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @param $membershipId
	 * @param GroupApplicationRequest $request
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function approvePending($groupId, $membershipType, $membershipId, GroupApplicationRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/Approve/' . $membershipType . '/' . $membershipId, $request->toArray());
	}

	/**
	 * @param $groupId
	 * @param GroupApplicationListRequest $request
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function denyPendingForList($groupId, GroupApplicationListRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/DenyList', $request->toArray());
	}

	/**
	 * @param $membershipType
	 * @param $membershipId
	 * @param $filter
	 * @param $groupType
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function getGroupsForMember($membershipType, $membershipId, $filter, $groupType)
	{
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);
		$this->assertIsEnum($filter, GroupsForMemberFilter::class);
		$this->assertIsEnum($groupType, GroupType::class);

		return $this->apiClient->get('GroupV2/User/' . $membershipType . '/' . $membershipId . '/' . $filter . '/' . $groupType);
	}

	/**
	 * @param $membershipType
	 * @param $membershipId
	 * @param $filter
	 * @param $groupType
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function getPotentialGroupsForMember($membershipType, $membershipId, $filter, $groupType)
	{
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);
		$this->assertIsEnum($filter, GroupsForMemberFilter::class);
		$this->assertIsEnum($groupType, GroupType::class);

		return $this->apiClient->get('GroupV2/User/Potential/' . $membershipType . '/' . $membershipId . '/' . $filter . '/' . $groupType);
	}

	/**
	 * @param $groupId
	 * @param $membershipType
	 * @param $membershipId
	 * @param GroupApplicationRequest $request
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidGroupId
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function individualGroupInvite($groupId, $membershipType, $membershipId, GroupApplicationRequest $request)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/IndividualInvite/' . $membershipType . '/' . $membershipId, $request->toArray());
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
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray
	 */
	public function individualGroupInviteCancel($groupId, $membershipType, $membershipId)
	{
		$this->assertHasAccessToken();
		$this->assertIsGroupId($groupId);
		$this->assertIsMembershipId($membershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('GroupV2/' . $groupId . '/Members/IndividualInviteCancel/' . $membershipType . '/' . $membershipId);
	}
}