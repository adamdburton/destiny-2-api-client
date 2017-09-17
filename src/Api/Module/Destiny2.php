<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Enum\Activity;
use AdamDBurton\Destiny2ApiClient\Enum\Component;
use AdamDBurton\Destiny2ApiClient\Enum\Period;
use AdamDBurton\Destiny2ApiClient\Enum\StatsGroup;

class Destiny2 extends Module
{
	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getDestinyManifest()
	{
		return $this->apiClient->get('Destiny2/Manifest');
	}

	/**
	 * @param $entityType
	 * @param $itemHash
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemHash
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getDestinyEntityDefinition($entityType, $itemHash)
	{
		$this->assertIsItemHash($itemHash);

		return $this->apiClient->get('Destiny2/Manifest/' . $entityType . '/' . $itemHash);
	}

	/**
	 * @param $membershipType
	 * @param $displayName
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function searchDestinyPlayer($membershipType, $displayName)
	{
		$this->assertIsMembershipType($membershipType);

		return $this->apiClient->get('Destiny2/SearchDestinyPlayer/' . $membershipType . '/' . $displayName);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $components
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidComponentType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getProfile($membershipType, $destinyMembershipId, $components)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsMembershipId($destinyMembershipId);
		$this->assertIsComponentType($components);

		$components = implode(',', Component::getEnumStringsFor($components));

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId, [
			'components' => $components
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getCharacter($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId);
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
	public function getClanWeeklyRewardState($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Clan/' . $groupId . '/WeeklyRewardState');
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $itemInstanceId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getItem($membershipType, $destinyMembershipId, $itemInstanceId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Item/' . $itemInstanceId);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getVendors($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors');
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param $vendorHash
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidVendorHash
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getVendor($membershipType, $destinyMembershipId, $characterId, $vendorHash)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsVendorHash($vendorHash);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors/' . $vendorHash);
	}

	/**
	 * @param $itemHash
	 * @param $stackSize
	 * @param $toVault
	 * @param $itemInstanceId
	 * @param $characterId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemHash
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function transferItem($itemHash, $stackSize, $toVault, $itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemHash($itemHash);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/TransferItem', [
			'itemReferenceHash' => $itemHash,
			'stackSize' => $stackSize,
			'transferToVault' => $toVault,
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $itemInstanceId
	 * @param $characterId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function equipItem($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/EquipItem', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $itemInstanceIds
	 * @param $characterId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function equipItems($itemInstanceIds, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceIds);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/EquipItems', [
			'itemIds' => $itemInstanceIds,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $state
	 * @param $itemInstanceId
	 * @param $characterId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function setItemLockState($state, $itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/SetLockState', [
			'state' => $state,
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $itemInstanceId
	 * @param $characterId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function insertSocketPlug($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/InsertSocketPlug', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $itemInstanceId
	 * @param $characterId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function activateTalentNode($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/ActivateTalentNode', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $activityId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidItemActivityId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getPostGameCarnageReport($activityId)
	{
		$this->assertIsActivityId($activityId);

		return $this->apiClient->get('Destiny2/Stats/PostGameCarnageReport/' . $activityId);
	}

	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getHistoricalStatsDefinition()
	{
		return $this->apiClient->get('Destiny2/Stats/Definition');
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
	public function getClanLeaderboards($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Stats/Leaderboards/Clans/' . $groupId);
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
	public function getClanAggregateStats($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Stats/AggregateClanStats/' . $groupId);
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $maxPlayers
	 * @param $modes
	 * @param $statId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidActivityType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getLeaderboards($membershipTypeId, $destinyMembershipId, $maxPlayers, $modes, $statId)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsActivityType($modes);

		$modes = implode(',', Activity::getEnumStringsFor($modes));

		return $this->apiClient->get('Destiny2/' . $membershipTypeId .'/Account/' . $destinyMembershipId . '/Stats/Leaderboards', [
			'maxtop' => $maxPlayers,
			'modes' => $modes,
			'statid' => $statId
		]);
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param null $maxPlayers
	 * @param null $modes
	 * @param null $statId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidActivityType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getLeaderboardsForCharacter($membershipTypeId, $destinyMembershipId, $characterId, $maxPlayers = null, $modes = null, $statId = null)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsActivityType($modes);

		$modes = $modes ? implode(',', Activity::getEnumStringsFor($modes)) : null;

		return $this->apiClient->get('Destiny2/Stats/Leaderboard/' . $membershipTypeId .'/' . $destinyMembershipId . '/' . $characterId, [
			'maxtop' => $maxPlayers,
			'modes' => $modes,
			'statid' => $statId
		]);
	}

	/**
	 * @param $entityType
	 * @param $searchTerm
	 * @param int $page
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function searchDestinyEntities($entityType, $searchTerm, $page = 0)
	{
		return $this->apiClient->get('Destiny2/Armory/Search/' . $entityType . '/' . $searchTerm, [
			'page' => $page
		]);
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param null $dayEnd
	 * @param null $dayStart
	 * @param null $groups
	 * @param null $modes
	 * @param null $periodType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getHistoricalStats($membershipTypeId, $destinyMembershipId, $characterId, $dayEnd = null, $dayStart = null, $groups = null, $modes = null, $periodType = null)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		$modes = $modes ? implode(',', Activity::getEnumStringsFor($modes)) : null;
		$groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats', [
			'dayend' => $dayEnd,
			'daystart' => $dayStart,
			'groups' => $groups,
			'modes' => $modes,
			'periodType' => Period::getEnumStringFor($periodType)
		]);
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $groups
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function GetHistoricalStatsForAccount($membershipTypeId, $destinyMembershipId, $groups)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);

		$groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats', [
			'groups' => $groups
		]);
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param null $count
	 * @param null $mode
	 * @param int $page
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getActivityHistory($membershipTypeId, $destinyMembershipId, $characterId, $count = null, $mode = null, $page = 0)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/Activities', [
			'count' => $count,
			'mode' => $mode,
			'page' => $page
		]);
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getUniqueWeaponHistory($membershipTypeId, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/UniqueWeapons');
	}

	/**
	 * @param $membershipTypeId
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getDestinyAggregateActivityStats($membershipTypeId, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/AggregateActivityStats');
	}

	/**
	 * @param $milestoneHash
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMilestoneHash
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getPublicMilestoneContent($milestoneHash)
	{
		$this->assertIsMilestoneHash($milestoneHash);

		return $this->apiClient->get('Destiny2/Milestones/' . $milestoneHash . '/Content');
	}

	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function getPublicMilestones()
	{
		return $this->apiClient->get('Destiny2/Milestones');
	}
}