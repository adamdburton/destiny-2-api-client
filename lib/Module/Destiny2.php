<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\Api\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidActivityType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidCharacterId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidComponentType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidDestinyMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidItemActivityId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidItemHash;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidItemInstanceId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMilestoneHash;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidVendorHash;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyActivityModeType;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyComponentType;
use AdamDBurton\Destiny2ApiClient\Enum\Period;
use AdamDBurton\Destiny2ApiClient\Enum\StatsGroup;
use AdamDBurton\Destiny2ApiClient\Response\Destiny2\ActivityHistory;

/**
 * @package AdamDBurton\Destiny2ApiClient\Module
 */
class Destiny2 extends Module
{
    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getGlobalAlerts()
    {
        return $this->request('GlobalAlerts')->get();
    }

    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getDestinyManifest()
    {
        return $this->request('Destiny2/Manifest')->get();
    }

    /**
     * @param $entityType
     * @param $itemHash
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidItemHash
     */
    public function getDestinyEntityDefinition($entityType, $itemHash)
    {
        $this->assertIsItemHash($itemHash);

        return $this->request('Destiny2/Manifest/' . $entityType . '/' . $itemHash)->get();
    }

    /**
     * @param $membershipType
     * @param $displayName
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidMembershipType
     */
    public function searchDestinyPlayer($membershipType, $displayName)
    {
        $this->assertIsMembershipType($membershipType);

        return $this->request('Destiny2/SearchDestinyPlayer/' . $membershipType . '/' . $displayName)->get();
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidComponentType
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidMembershipId
     */
    public function getProfile($membershipType, $destinyMembershipId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsMembershipId($destinyMembershipId);
        $this->assertIsComponentType($components);

        $components = implode(',', DestinyComponentType::getEnumStringsFor($components));

        return $this->request('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId)
            ->withParams(['components' => $components])
            ->get();
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $characterId
     * @param $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getCharacter($membershipType, $destinyMembershipId, $characterId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        $components = implode(',', DestinyComponentType::getEnumStringsFor($components));

        return $this->request('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId)
            ->withParams(['components' => $components])
            ->get();
    }

    /**
     * @param $groupId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidGroupId
     */
    public function getClanWeeklyRewardState($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request('Destiny2/Clan/' . $groupId . '/WeeklyRewardState')->get();
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $itemInstanceId
     * @param $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidComponentType
     * @throws InvalidDestinyMembershipId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     */
    public function getItem($membershipType, $destinyMembershipId, $itemInstanceId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsItemInstanceId($itemInstanceId);
        $this->assertIsComponentType($components);

        $components = implode(',', DestinyComponentType::getEnumStringsFor($components));

        return $this->request('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Item/' . $itemInstanceId)
            ->withParams(['components' => $components])
            ->get();
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $characterId
     * @param $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidComponentType
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidCharacterId
     */
    public function getVendors($membershipType, $destinyMembershipId, $characterId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsComponentType($components);

        $components = implode(',', DestinyComponentType::getEnumStringsFor($components));

        return $this->request('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors')
            ->withParams(['components' => $components])
            ->get();
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $characterId
     * @param $vendorHash
     * @param $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidComponentType
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidVendorHash
     */
    public function getVendor($membershipType, $destinyMembershipId, $characterId, $vendorHash, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsVendorHash($vendorHash);
        $this->assertIsComponentType($components);

        $components = implode(',', DestinyComponentType::getEnumStringsFor($components));

        return $this->request('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors/' . $vendorHash)
            ->withParams(['components' => $components])
            ->get();
    }

    /**
     * @param $itemHash
     * @param $stackSize
     * @param $toVault
     * @param $itemInstanceId
     * @param $characterId
     * @param $membershipType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws AccessTokenRequired
     * @throws InvalidItemHash
     */
    public function transferItem($itemHash, $stackSize, $toVault, $itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemHash($itemHash);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request('Destiny2/Actions/Items/TransferItem')
            ->withBody([
                'itemReferenceHash' => $itemHash,
                'stackSize' => $stackSize,
                'transferToVault' => $toVault,
                'itemId' => $itemInstanceId,
                'characterId' => $characterId,
                'membershipType' => $membershipType
            ])
            ->postAsJson();
    }

    /**
     * @param $itemInstanceId
     * @param $characterId
     * @param $membershipType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws AccessTokenRequired
     */
    public function equipItem($itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request('Destiny2/Actions/Items/EquipItem')
            ->withBody([
                'itemId' => $itemInstanceId,
                'characterId' => $characterId,
                'membershipType' => $membershipType
            ])
            ->postAsJson();
    }

    /**
     * @param $itemInstanceIds
     * @param $characterId
     * @param $membershipType
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function equipItems($itemInstanceIds, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceIds);

        return $this->request('Destiny2/Actions/Items/EquipItems')
            ->withBody([
                'itemIds' => $itemInstanceIds,
                'characterId' => $characterId,
                'membershipType' => $membershipType
            ])
            ->postAsJson();
    }

    /**
     * @param $state
     * @param $itemInstanceId
     * @param $characterId
     * @param $membershipType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws AccessTokenRequired
     */
    public function setItemLockState($state, $itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request('Destiny2/Actions/Items/SetLockState')
            ->withBody([
                'state' => $state,
                'itemId' => $itemInstanceId,
                'characterId' => $characterId,
                'membershipType' => $membershipType
            ])
            ->postAsJson();
    }

    /**
     * @param $itemInstanceId
     * @param $characterId
     * @param $membershipType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws AccessTokenRequired
     */
    public function insertSocketPlug($itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request('Destiny2/Actions/Items/InsertSocketPlug')
            ->withBody([
                'itemId' => $itemInstanceId,
                'characterId' => $characterId,
                'membershipType' => $membershipType
            ])
            ->postAsJson();
    }

    /**
     * @param $itemInstanceId
     * @param $characterId
     * @param $membershipType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidItemInstanceId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws AccessTokenRequired
     */
    public function activateTalentNode($itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request('Destiny2/Actions/Items/ActivateTalentNode')
            ->withBody([
                'itemId' => $itemInstanceId,
                'characterId' => $characterId,
                'membershipType' => $membershipType
            ])
            ->postAsJson();
    }

    /**
     * @param $activityId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidItemActivityId
     */
    public function getPostGameCarnageReport($activityId)
    {
        $this->assertIsActivityId($activityId);

        return $this->request('Destiny2/Stats/PostGameCarnageReport/' . $activityId)->get();
    }

    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getHistoricalStatsDefinition()
    {
        return $this->request('Destiny2/Stats/Definition')->get();
    }

    /**
     * @param $groupId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidGroupId
     */
    public function getClanLeaderboards($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request('Destiny2/Stats/Leaderboards/Clans/' . $groupId)->get();
    }

    /**
     * @param $groupId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidGroupId
     */
    public function getClanAggregateStats($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request('Destiny2/Stats/AggregateClanStats/' . $groupId)->get();
    }

    /**
     * @param $membershipTypeId
     * @param $destinyMembershipId
     * @param $maxPlayers
     * @param $modes
     * @param $statId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidActivityType
     */
    public function getLeaderboards($membershipTypeId, $destinyMembershipId, $maxPlayers, $modes, $statId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsActivityType($modes);

        $modes = $modes ? implode(',', DestinyActivityModeType::getEnumStringsFor($modes)) : null;

        return $this->request('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats/Leaderboards')
            ->withParams([
                'maxtop' => $maxPlayers,
                'modes' => $modes,
                'statid' => $statId
            ])
            ->get();
    }

    /**
     * @param $membershipTypeId
     * @param $destinyMembershipId
     * @param $characterId
     * @param null $maxPlayers
     * @param null $modes
     * @param null $statId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidActivityType
     */
    public function getLeaderboardsForCharacter($membershipTypeId, $destinyMembershipId, $characterId, $maxPlayers = null, $modes = null, $statId = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsActivityType($modes);

        $modes = $modes ? implode(',', DestinyActivityModeType::getEnumStringsFor($modes)) : null;

        return $this->request('Destiny2/Stats/Leaderboards/' . $membershipTypeId . '/' . $destinyMembershipId . '/' . $characterId)
            ->withParams([
                'maxtop' => $maxPlayers,
                'modes' => $modes,
                'statid' => $statId
            ])
            ->get();
    }

    /**
     * @param $entityType
     * @param $searchTerm
     * @param int $page
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function searchDestinyEntities($entityType, $searchTerm, $page = 0)
    {
        return $this->request('Destiny2/Armory/Search/' . $entityType . '/' . $searchTerm)
            ->withParams([
                'page' => $page
            ])
            ->get();
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
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getHistoricalStats($membershipTypeId, $destinyMembershipId, $characterId, $dayEnd = null, $dayStart = null, $groups = null, $modes = null, $periodType = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        $modes = $modes ? implode(',', DestinyActivityModeType::getEnumStringsFor($modes)) : null;
        $groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

        return $this->request('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats')
            ->withParams([
                'dayend' => $dayEnd,
                'daystart' => $dayStart,
                'groups' => $groups,
                'modes' => $modes,
                'periodType' => $periodType ? Period::getEnumStringFor($periodType) : null
            ])
            ->get();
    }

    /**
     * @param $membershipTypeId
     * @param $destinyMembershipId
     * @param null $groups
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getHistoricalStatsForAccount($membershipTypeId, $destinyMembershipId, $groups = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);

        $groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

        return $this->request('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats')
            ->withParams([
                'groups' => $groups
            ])
            ->get();
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
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getActivityHistory($membershipTypeId, $destinyMembershipId, $characterId, $count = null, $mode = null, $page = 0)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        return $this
            ->request('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/Activities')
            ->withResponse(ActivityHistory::class)
            ->withParams([
                'count' => $count,
                'mode' => $mode,
                'page' => $page
            ])
            ->get();
    }

    /**
     * @param $membershipTypeId
     * @param $destinyMembershipId
     * @param $characterId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getUniqueWeaponHistory($membershipTypeId, $destinyMembershipId, $characterId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        return $this->request('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/UniqueWeapons')->get();
    }

    /**
     * @param $membershipTypeId
     * @param $destinyMembershipId
     * @param $characterId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidCharacterId
     * @throws InvalidDestinyMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getDestinyAggregateActivityStats($membershipTypeId, $destinyMembershipId, $characterId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        return $this->request('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/AggregateActivityStats')->get();
    }

    /**
     * @param $milestoneHash
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidMilestoneHash
     */
    public function getPublicMilestoneContent($milestoneHash)
    {
        $this->assertIsMilestoneHash($milestoneHash);

        return $this->request('Destiny2/Milestones/' . $milestoneHash . '/Content')->get();
    }

    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getPublicMilestones()
    {
        return $this->request('Destiny2/Milestones')->get();
    }
}
