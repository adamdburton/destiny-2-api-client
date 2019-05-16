<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Enum\Activity;
use AdamDBurton\Destiny2ApiClient\Enum\Component;
use AdamDBurton\Destiny2ApiClient\Enum\Period;
use AdamDBurton\Destiny2ApiClient\Enum\StatsGroup;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidActivityType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidComponentType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemActivityId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemHash;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMilestoneHash;
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
     * @throws ApiKeyRequired
     */
    public function getGlobalAlerts()
    {
        return $this->apiClient->get('/GlobalAlerts/');
    }


    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @throws ApiKeyRequired
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
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function searchDestinyPlayer($membershipType, $displayName)
    {
        $this->assertIsMembershipType($membershipType);

        return $this->apiClient->get('Destiny2/SearchDestinyPlayer/' . $membershipType . '/' . $displayName);
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param int|int[] $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidComponentType
     * @throws InvalidMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @param int|int[] $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getCharacter($membershipType, $destinyMembershipId, $characterId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        $components = implode(',', Component::getEnumStringsFor($components));

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
     * @throws ApiKeyRequired
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
     * @param int|int[] $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidDestinyMembershipId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidComponentType
     * @throws ApiKeyRequired
     */
    public function getItem($membershipType, $destinyMembershipId, $itemInstanceId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsItemInstanceId($itemInstanceId);
        $this->assertIsComponentType($components);
        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Item/' . $itemInstanceId, [
            'components' => $components
        ]);
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $characterId
     * @param int|int[] $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidComponentType
     * @throws ApiKeyRequired
     */
    public function getVendors($membershipType, $destinyMembershipId, $characterId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsComponentType($components);

        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors', [
            'components' => $components
        ]);
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $characterId
     * @param $vendorHash
     * @param int|int[] $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws InvalidVendorHash
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidComponentType
     * @throws ApiKeyRequired
     */
    public function getVendor($membershipType, $destinyMembershipId, $characterId, $vendorHash, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsVendorHash($vendorHash);
        $this->assertIsComponentType($components);

        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->apiClient->get('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors/' . $vendorHash, [
            'components' => $components
        ]);
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
     * @throws InvalidItemHash
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidItemActivityId
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @throws ApiKeyRequired
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
     * @throws ApiKeyRequired
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
     * @throws ApiKeyRequired
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
     * @param int|int[]|null $modes
     * @param $statId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidActivityType
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getLeaderboards($membershipTypeId, $destinyMembershipId, $maxPlayers, $modes, $statId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsActivityType($modes);

        $modes = implode(',', Activity::getEnumStringsFor($modes));

        return $this->apiClient->get('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats/Leaderboards', [
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
     * @param int|int[]|null $modes
     * @param null $statId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidActivityType
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getLeaderboardsForCharacter($membershipTypeId, $destinyMembershipId, $characterId, $maxPlayers = null, $modes = null, $statId = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsActivityType($modes);

        $modes = $modes ? implode(',', Activity::getEnumStringsFor($modes)) : null;

        return $this->apiClient->get('Destiny2/Stats/Leaderboards/' . $membershipTypeId . '/' . $destinyMembershipId . '/' . $characterId, [
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
     * @throws ApiKeyRequired
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
     * @param int|int[]|null $groups
     * @param int|int[]|null $modes
     * @param null $periodType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
            'periodType' => $periodType ? Period::getEnumStringFor($periodType) : null
        ]);
    }

    /**
     * @param $membershipTypeId
     * @param $destinyMembershipId
     * @param int|int[]|null $groups
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getHistoricalStatsForAccount($membershipTypeId, $destinyMembershipId, $groups = null)
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
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidMilestoneHash
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
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
     * @throws ApiKeyRequired
     */
    public function getPublicMilestones()
    {
        return $this->apiClient->get('Destiny2/Milestones');
    }
}
