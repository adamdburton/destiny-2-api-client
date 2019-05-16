<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Enum\Activity;
use AdamDBurton\Destiny2ApiClient\Enum\Component;
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
        return $this->request()
            ->endpoint('GlobalAlerts')
            ->get();
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
        return $this->request()
            ->endpoint('Destiny2/Manifest')
            ->get();
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
     */
    public function getDestinyEntityDefinition($entityType, $itemHash)
    {
        $this->assertIsItemHash($itemHash);

        return $this->request()
            ->endpoint('Destiny2/Manifest/' . $entityType . '/' . $itemHash)
            ->get();
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
     */
    public function searchDestinyPlayer($membershipType, $displayName)
    {
        $this->assertIsMembershipType($membershipType);

        return $this->request()
            ->endpoint('Destiny2/SearchDestinyPlayer/' . $membershipType . '/' . $displayName)
            ->get();
    }

    /**
     * @param $membershipType
     * @param $destinyMembershipId
     * @param $components
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getProfile($membershipType, $destinyMembershipId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsMembershipId($destinyMembershipId);
        $this->assertIsComponentType($components);

        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->request()
            ->endpoint('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId)
            ->params(['components' => $components])
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getCharacter($membershipType, $destinyMembershipId, $characterId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->request()
            ->endpoint('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId)
            ->params(['components' => $components])
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
     */
    public function getClanWeeklyRewardState($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request()
            ->endpoint('Destiny2/Clan/' . $groupId . '/WeeklyRewardState')
            ->get();
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
     */
    public function getItem($membershipType, $destinyMembershipId, $itemInstanceId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsItemInstanceId($itemInstanceId);
        $this->assertIsComponentType($components);
        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->request()
            ->endpoint('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Item/' . $itemInstanceId)
            ->params(['components' => $components])
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getVendors($membershipType, $destinyMembershipId, $characterId, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsComponentType($components);

        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->request()
            ->endpoint('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors')
            ->params(['components' => $components])
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getVendor($membershipType, $destinyMembershipId, $characterId, $vendorHash, $components)
    {
        $this->assertIsMembershipType($membershipType);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsVendorHash($vendorHash);
        $this->assertIsComponentType($components);

        $components = implode(',', Component::getEnumStringsFor($components));

        return $this->request()
            ->endpoint('Destiny2/' . $membershipType . '/Profile/' . $destinyMembershipId . '/Character/' . $characterId . '/Vendors/' . $vendorHash)
            ->params(['components' => $components])
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function transferItem($itemHash, $stackSize, $toVault, $itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemHash($itemHash);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request()
            ->endpoint('Destiny2/Actions/Items/TransferItem')
            ->postAsJson([
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
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function equipItem($itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request()
            ->endpoint('Destiny2/Actions/Items/EquipItem')
            ->postAsJson([
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
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function equipItems($itemInstanceIds, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceIds);

        return $this->request()
            ->endpoint('Destiny2/Actions/Items/EquipItems')
            ->postAsJson([
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
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function setItemLockState($state, $itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request()
            ->endpoint('Destiny2/Actions/Items/SetLockState')
            ->postAsJson([
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
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function insertSocketPlug($itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request()
            ->endpoint('Destiny2/Actions/Items/InsertSocketPlug')
            ->postAsJson([
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
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function activateTalentNode($itemInstanceId, $characterId, $membershipType)
    {
        $this->assertHasAccessToken();

        $this->assertIsMembershipType($membershipType);
        $this->assertIsCharacterId($characterId);
        $this->assertIsItemInstanceId($itemInstanceId);

        return $this->request()
            ->endpoint('Destiny2/Actions/Items/ActivateTalentNode')
            ->postAsJson([
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
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getPostGameCarnageReport($activityId)
    {
        $this->assertIsActivityId($activityId);

        return $this->request()
            ->endpoint('Destiny2/Stats/PostGameCarnageReport/' . $activityId)
            ->get();
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
        return $this->request()
            ->endpoint('Destiny2/Stats/Definition')
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
     */
    public function getClanLeaderboards($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request()
            ->endpoint('Destiny2/Stats/Leaderboards/Clans/' . $groupId)
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
     */
    public function getClanAggregateStats($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request()
            ->endpoint('Destiny2/Stats/AggregateClanStats/' . $groupId)
            ->get();
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getLeaderboards($membershipTypeId, $destinyMembershipId, $maxPlayers, $modes, $statId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsActivityType($modes);

        $modes = implode(',', Activity::getEnumStringsFor($modes));

        return $this->request()
            ->endpoint('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats/Leaderboards')
            ->params([
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getLeaderboardsForCharacter($membershipTypeId, $destinyMembershipId, $characterId, $maxPlayers = null, $modes = null, $statId = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);
        $this->assertIsActivityType($modes);

        $modes = $modes ? implode(',', Activity::getEnumStringsFor($modes)) : null;

        return $this->request()
            ->endpoint('Destiny2/Stats/Leaderboards/' . $membershipTypeId . '/' . $destinyMembershipId . '/' . $characterId)
            ->params([
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
        return $this->request()
            ->endpoint('Destiny2/Armory/Search/' . $entityType . '/' . $searchTerm)
            ->params([
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getHistoricalStats($membershipTypeId, $destinyMembershipId, $characterId, $dayEnd = null, $dayStart = null, $groups = null, $modes = null, $periodType = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        $modes = $modes ? implode(',', Activity::getEnumStringsFor($modes)) : null;
        $groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

        return $this->request()
            ->endpoint('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats')
            ->params([
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getHistoricalStatsForAccount($membershipTypeId, $destinyMembershipId, $groups = null)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);

        $groups = $groups ? implode(',', StatsGroup::getEnumStringsFor($groups)) : null;

        return $this->request()
            ->endpoint('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Stats')
            ->params([
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getActivityHistory($membershipTypeId, $destinyMembershipId, $characterId, $count = null, $mode = null, $page = 0)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        return $this
            ->request(ActivityHistory::class)
            ->endpoint('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/Activities')
            ->params([
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getUniqueWeaponHistory($membershipTypeId, $destinyMembershipId, $characterId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        return $this->request()
            ->endpoint('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/UniqueWeapons')
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
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getDestinyAggregateActivityStats($membershipTypeId, $destinyMembershipId, $characterId)
    {
        $this->assertIsMembershipType($membershipTypeId);
        $this->assertIsDestinyMembershipId($destinyMembershipId);
        $this->assertIsCharacterId($characterId);

        return $this->request()
            ->endpoint('Destiny2/' . $membershipTypeId . '/Account/' . $destinyMembershipId . '/Character/' . $characterId . '/Stats/AggregateActivityStats')
            ->get();
    }

    /**
     * @param $milestoneHash
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getPublicMilestoneContent($milestoneHash)
    {
        $this->assertIsMilestoneHash($milestoneHash);

        return $this->request()
            ->endpoint('Destiny2/Milestones/' . $milestoneHash . '/Content')
            ->get();
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
        return $this->request()
            ->endpoint('Destiny2/Milestones')
            ->get();
    }
}
