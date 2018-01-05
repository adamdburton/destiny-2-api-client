<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Api\Response;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyActivityModeType;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyComponentType;
use AdamDBurton\Destiny2ApiClient\Enum\Period;
use AdamDBurton\Destiny2ApiClient\Enum\StatsGroup;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemActivityId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemHash;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidVendorHash;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class Destiny2 extends Module
{
	/**
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getDestinyManifest()
	{
		return $this->apiClient->get('Destiny2/Manifest');
	}

	/**
	 * @param $entityType
	 * @param $itemHash
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidItemHash
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getDestinyEntityDefinition($entityType, $itemHash)
	{
		$this->assertIsItemHash($itemHash);

		return $this->apiClient->get('Destiny2/Manifest/' . $entityType . '/' . $itemHash);
	}

	/**
	 * @param $membershipType
	 * @param $displayName
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function searchDestinyPlayer($membershipType, $displayName)
	{
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/SearchDestinyPlayer/' . $membershipType . '/' . $displayName);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $components
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidMembershipId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getProfile($membershipType, $destinyMembershipId, $components)
	{
		$this->assertIsMembershipId($destinyMembershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);
		$this->assertIsEnum($components, DestinyComponentType::class, true);

		$components = implode(',', DestinyComponentType::getEnumStringsFor($components));

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId, [
			'components' => $components
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param $components
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getCharacter($membershipType, $destinyMembershipId, $characterId, $components)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		$components = implode(',', DestinyComponentType::getEnumStringsFor($components));

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId, [
			'components' => $components
		]);
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
	public function getClanWeeklyRewardState($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Clan/' . $groupId . '/WeeklyRewardState');
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $itemInstanceId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getItem($membershipType, $destinyMembershipId, $itemInstanceId)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsItemInstanceId($itemInstanceId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Item/' . $itemInstanceId);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getVendors($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors');
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param $vendorHash
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidVendorHash
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getVendor($membershipType, $destinyMembershipId, $characterId, $vendorHash)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsVendorHash($vendorHash);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors/' . $vendorHash);
	}

	/**
	 * @param $itemHash
	 * @param $stackSize
	 * @param $toVault
	 * @param $itemInstanceId
	 * @param $characterId
	 * @param $membershipType
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemHash
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function transferItem($itemHash, $stackSize, $toVault, $itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemHash($itemHash);
		$this->assertIsItemInstanceId($itemInstanceId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function equipItem($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function equipItems($itemInstanceIds, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceIds);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function setItemLockState($state, $itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function insertSocketPlug($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

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
	 * @return Response
	 * @throws AccessTokenRequired
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidItemInstanceId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function activateTalentNode($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->postAsJson('Destiny2/Actions/Items/ActivateTalentNode', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	/**
	 * @param $activityId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidItemActivityId
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getPostGameCarnageReport($activityId)
	{
		$this->assertIsActivityId($activityId);

		return $this->apiClient->get('Destiny2/Stats/PostGameCarnageReport/' . $activityId);
	}

	/**
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getHistoricalStatsDefinition()
	{
		return $this->apiClient->get('Destiny2/Stats/Definition');
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
	public function getClanLeaderboards($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Stats/Leaderboards/Clans/' . $groupId);
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
	public function getClanAggregateStats($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Stats/AggregateClanStats/' . $groupId);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $maxPlayers
	 * @param $modes
	 * @param $statId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getLeaderboards($membershipType, $destinyMembershipId, $maxPlayers, $modes, $statId)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);
		$this->assertIsEnum($modes, DestinyActivityModeType::class);

		$modes = implode(',', DestinyActivityModeType::getEnumStringsFor($modes));

		return $this->apiClient->get('Destiny2/' . $membershipType .'/Account/' . $destinyMembershipId . '/Stats/Leaderboards', [
			'maxtop' => $maxPlayers,
			'modes' => $modes,
			'statid' => $statId
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param null $maxPlayers
	 * @param null $modes
	 * @param null $statId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getLeaderboardsForCharacter($membershipType, $destinyMembershipId, $characterId, $maxPlayers = null, $modes = null, $statId = null)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);
		$this->assertIsEnum($modes, DestinyActivityModeType::class);

		$modes = $modes ? implode(',', DestinyActivityModeType::getEnumStringsFor($modes)) : null;

		return $this->apiClient->get('Destiny2/Stats/Leaderboards/' . $membershipType .'/' . $destinyMembershipId . '/' . $characterId, [
			'maxtop' => $maxPlayers,
			'modes' => $modes,
			'statid' => $statId
		]);
	}

	/**
	 * @param $entityType
	 * @param $searchTerm
	 * @param int $page
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function searchDestinyEntities($entityType, $searchTerm, $page = 0)
	{
		return $this->apiClient->get('Destiny2/Armory/Search/' . $entityType . '/' . $searchTerm, [
			'page' => $page
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param null $dayEnd
	 * @param null $dayStart
	 * @param null $groups
	 * @param null $modes
	 * @param null $periodType
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getHistoricalStats($membershipType, $destinyMembershipId, $characterId, $dayEnd = null, $dayStart = null, $groups = null, $modes = null, $periodType = null)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		$modes = $modes ? implode(',', DestinyActivityModeType::getEnumStringsFor($modes)) : null;
		$groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats', [
			'dayend' => $dayEnd,
			'daystart' => $dayStart,
			'groups' => $groups,
			'modes' => $modes,
			'periodType' => $periodType ? Period::getEnumStringFor($periodType) : null
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param null $groups
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getHistoricalStatsForAccount($membershipType, $destinyMembershipId, $groups = null)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		$groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Account/' . $destinyMembershipId . '/Stats', [
			'groups' => $groups
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @param null $count
	 * @param null $mode
	 * @param int $page
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getActivityHistory($membershipType, $destinyMembershipId, $characterId, $count = null, $mode = null, $page = 0)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/Activities', [
			'count' => $count,
			'mode' => $mode,
			'page' => $page
		]);
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getUniqueWeaponHistory($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/UniqueWeapons');
	}

	/**
	 * @param $membershipType
	 * @param $destinyMembershipId
	 * @param $characterId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidCharacterId
	 * @throws InvalidDestinyMembershipId
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getDestinyAggregateActivityStats($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/AggregateActivityStats');
	}

	/**
	 * @param $milestoneHash
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMilestoneHash
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getPublicMilestoneContent($milestoneHash)
	{
		$this->assertIsMilestoneHash($milestoneHash);

		return $this->apiClient->get('Destiny2/Milestones/' . $milestoneHash . '/Content');
	}

	/**
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getPublicMilestones()
	{
		return $this->apiClient->get('Destiny2/Milestones');
	}
}