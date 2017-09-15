<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Enum\Activity;
use AdamDBurton\Destiny2ApiClient\Enum\Period;
use AdamDBurton\Destiny2ApiClient\Enum\StatsGroup;

class Destiny2 extends Module
{
	public function getDestinyManifest()
	{
		return $this->apiClient->get('Destiny2/Manifest');
	}

	public function getDestinyEntityDefinition($entityType, $itemHash)
	{
		$this->assertIsItemHash($itemHash);

		return $this->apiClient->get('Destiny2/Manifest/' . $entityType . '/' . $itemHash);
	}

	public function searchDestinyPlayer($membershipType, $displayName)
	{
		$this->assertIsMembershipType($membershipType);

		return $this->apiClient->get('Destiny2/SearchDestinyPlayer/' . $membershipType . '/' . $displayName);
	}

	public function getProfile($membershipType, $destinyMembershipId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsMembershipId($destinyMembershipId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId);
	}

	public function getCharacter($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId);
	}

	public function getClanWeeklyRewardState($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Clan/' . $groupId . '/WeeklyRewardState');
	}

	public function getItem($membershipType, $destinyMembershipId, $itemInstanceId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Item/' . $itemInstanceId);
	}

	public function getVendors($membershipType, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors');
	}

	public function getVendor($membershipType, $destinyMembershipId, $characterId, $vendorHash)
	{
		$this->assertIsMembershipType($membershipType);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);
		$this->assertIsVendorHash($vendorHash);

		return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors/' . $vendorHash);
	}

	public function transferItem($itemHash, $stackSize, $toVault, $itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemHash($itemHash);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->post('Destiny2/Actions/Items/TransferItem', [
			'itemReferenceHash' => $itemHash,
			'stackSize' => $stackSize,
			'transferToVault' => $toVault,
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	public function equipItem($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->post('Destiny2/Actions/Items/EquipItem', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	public function equipItems($itemInstanceIds, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceIds);

		return $this->apiClient->post('Destiny2/Actions/Items/EquipItems', [
			'itemIds' => $itemInstanceIds,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	public function setItemLockState($state, $itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->post('Destiny2/Actions/Items/SetLockState', [
			'state' => $state,
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	public function insertSocketPlug($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->post('Destiny2/Actions/Items/InsertSocketPlug', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	public function activateTalentNode($itemInstanceId, $characterId, $membershipType)
	{
		$this->assertHasAccessToken();

		$this->assertIsMembershipType($membershipType);
		$this->assertIsCharacterId($characterId);
		$this->assertIsItemInstanceId($itemInstanceId);

		return $this->apiClient->post('Destiny2/Actions/Items/ActivateTalentNode', [
			'itemId' => $itemInstanceId,
			'characterId' => $characterId,
			'membershipType' => $membershipType
		]);
	}

	public function getPostGameCarnageReport($activityId)
	{
		$this->assertIsActivityId($activityId);

		return $this->apiClient->get('Destiny2/Stats/PostGameCarnageReport/' . $activityId);
	}

	public function getHistoricalStatsDefinition()
	{
		return $this->apiClient->get('Destiny2/Stats/Definition');
	}

	public function getClanLeaderboards($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Stats/Leaderboards/Clans/' . $groupId);
	}

	public function getClanAggregateStats($groupId)
	{
		$this->assertIsGroupId($groupId);

		return $this->apiClient->get('Destiny2/Stats/AggregateClanStats/' . $groupId);
	}

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

	public function searchDestinyEntities($entityType, $searchTerm, $page = 0)
	{
		return $this->apiClient->get('Destiny2/Armory/Search/' . $entityType . '/' . $searchTerm, [
			'page' => $page
		]);
	}

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

	public function GetHistoricalStatsForAccount($membershipTypeId, $destinyMembershipId, $groups)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);

		$groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats', [
			'groups' => $groups
		]);
	}

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

	public function getUniqueWeaponHistory($membershipTypeId, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/UniqueWeapons');
	}

	public function getDestinyAggregateActivityStats($membershipTypeId, $destinyMembershipId, $characterId)
	{
		$this->assertIsMembershipType($membershipTypeId);
		$this->assertIsDestinyMembershipId($destinyMembershipId);
		$this->assertIsCharacterId($characterId);

		return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/AggregateActivityStats');
	}

	public function getPublicMilestoneContent($milestoneHash)
	{
		$this->assertIsMilestoneHash($milestoneHash);

		return $this->apiClient->get('Destiny2/Milestones/' . $milestoneHash . '/Content');
	}

	public function getPublicMilestones()
	{
		return $this->apiClient->get('Destiny2/Milestones');
	}
}