<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class User extends Module
{
    /**
     * @param $membershipId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidMembershipId
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     * @throws ApiKeyRequired
     */
    public function getBungieNetUserById($membershipId)
    {
        $this->assertIsMembershipId($membershipId);

        return $this->apiClient->get('User/GetBungieNetUserById/' . $membershipId);
    }

    /**
     * @param $membershipId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidMembershipId
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getUserByAliases($membershipId)
    {
        $this->assertIsMembershipId($membershipId);

        return $this->apiClient->get('User/GetUserAliases/' . $membershipId);
    }

    /**
     * @param $search
     * @return Response
     * @throws ApiKeyRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function searchUsers($search)
    {
        return $this->apiClient->get('User/SearchUsers/', ['q' => $search]);
    }

    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getAvailableThemes()
    {
        return $this->apiClient->get('User/GetAvailableThemes');
    }

    /**
     * @param $membershipId
     * @param $membershipType
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidMembershipId
     * @throws InvalidMembershipType
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getMembershipDataById($membershipId, $membershipType)
    {
        $this->assertIsMembershipId($membershipId);
        $this->assertIsMembershipType($membershipType);

        return $this->apiClient->get('User/GetMembershipDataById/' . $membershipId . '/' . $membershipType);
    }

    /**
     * @return Response
     * @throws AccessTokenRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getMembershipDataForCurrentUser()
    {
        $this->assertHasAccessToken();

        return $this->apiClient->get('User/GetMembershipsForCurrentUser');
    }

    /**
     * @param $membershipId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidMembershipId
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getPartnerships($membershipId)
    {
        $this->assertIsMembershipId($membershipId);

        return $this->apiClient->get('User/' . $membershipId . '/Partnerships');
    }
}