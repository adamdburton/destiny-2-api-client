<?php

namespace AdamDBurton\Destiny2ApiClient\Module;


use AdamDBurton\Destiny2ApiClient\Exception\Api\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidBoolean;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupDateRange;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidString;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\RequestParam\ClanBanner;
use AdamDBurton\Destiny2ApiClient\RequestParam\Group;
use AdamDBurton\Destiny2ApiClient\RequestParam\GroupEdit;
use AdamDBurton\Destiny2ApiClient\RequestParam\GroupQuery;
use AdamDBurton\Destiny2ApiClient\Response;

/**
 * @package AdamDBurton\Destiny2ApiClient\Api\Module
 */
class GroupV2 extends Module
{
    /**
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getAvailableAvatars()
    {
        $this->assertHasAccessToken();

        return $this->request('GroupV2/GetAvailableAvatars')->get();
    }

    /**
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getAvailableThemes()
    {
        $this->assertHasAccessToken();

        return $this->request('GroupV2/GetAvailableThemes')->get();
    }

    /**
     * @param $membershipType
     * @param $allow
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidMembershipType
     * @throws InvalidBoolean
     */
    public function setUserClanInviteSetting($membershipType, $allow)
    {
        $this->assertHasAccessToken();
        $this->assertIsMembershipType($membershipType);
        $this->assertIsBoolean($allow);

        return $this->request('GroupV2/GetUserClanInviteSetting/' . $membershipType . '/' . ($allow ? 1 : 0))->get();
    }

    /**
     * @param $groupType
     * @param $dateRange
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidGroupDateRange
     * @throws InvalidGroupType
     */
    public function getRecommendedGroups($groupType, $dateRange)
    {
        $this->assertHasAccessToken();
        $this->assertIsGroupType($groupType);
        $this->assertIsGroupDateRange($dateRange);

        return $this->request('GroupV2/Recommended/' . $groupType . '/' . $dateRange)->get();
    }

    /**
     * @param GroupQuery $groupQuery
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function search(GroupQuery $groupQuery)
    {
        $this->assertHasAccessToken();

        return $this->request('GroupV2/Search')->withRequestParam($groupQuery)->postAsJson();
    }

    /**
     * @param $groupId
     * @return mixed
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidGroupId
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getGroup($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request('GroupV2/' . $groupId)->get();
    }

    /**
     * @param $name
     * @param $groupType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidGroupType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidString
     */
    public function getGroupByName($name, $groupType)
    {
        $this->assertIsString($name);
        $this->assertIsGroupType($groupType);

        return $this->request('GroupV2/Name/' . $name . '/' . $groupType)->get();
    }

    /**
     * @param $groupId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidGroupId
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getGroupOptionalConversations($groupId)
    {
        $this->assertIsGroupId($groupId);

        return $this->request('GroupV2/' . $groupId . '/OptionalConversations')->get();
    }

    /**
     * @param Group $request
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function createGroup(Group $request)
    {
        $this->assertHasAccessToken();

        $this->request('GroupV2/Create')->withRequestParam($request)->postAsJson();
    }

    /**
     * @param $groupId
     * @param GroupEdit $groupEdit
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidGroupId
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function editGroup($groupId, GroupEdit $groupEdit)
    {
        $this->assertHasAccessToken();
        $this->assertIsGroupId($groupId);

        $this->request('GroupV2/' . $groupId . '/Edit')
            ->withRequestParam($groupEdit)
            ->postAsJson();
    }

    /**
     * @param $groupId
     * @param ClanBanner $clanBanner
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidGroupId
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function editClanBanner($groupId, ClanBanner $clanBanner)
    {
        $this->assertHasAccessToken();
        $this->assertIsGroupId($groupId);

        $this->request('GroupV2/' . $groupId . '/EditClanBanner')->withRequestParam($clanBanner)->postAsJson();
    }
}