<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\CommunityContentSortMode;
use AdamDBurton\Destiny2ApiClient\Enum\CommunityStatusSort;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyActivityModeType;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicsCategoryFilters;
use AdamDBurton\Destiny2ApiClient\Enum\PartnershipType;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidEnum;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidEnumArray;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidString;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;

/**
 * @package AdamDBurton\Destiny2ApiClient\Module
 */
class CommunityContent extends Module
{
    /**
     * @param $sort
     * @param $mediaFilter
     * @param $page
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     */
    public function getCommunityContent($sort, $mediaFilter, $page)
    {
        $this->assertIsInt($page);
        $this->assertIsEnum($mediaFilter, ForumTopicsCategoryFilters::class);
        $this->assertIsEnum($sort, CommunityContentSortMode::class);

        return $this->request('CommunityContent/Get/' . $sort . '/' . $mediaFilter . '/' . $page)->get();
    }

    /**
     * @param $partnershipType
     * @param $sort
     * @param $page
     * @param $modeHash
     * @param string $streamLocale
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidString
     */
    public function getCommunityLiveStatuses($partnershipType, $sort, $page, $modeHash, $streamLocale = 'ALL')
    {
        $this->assertIsEnum($partnershipType, PartnershipType::class);
        $this->assertIsEnum($sort, CommunityStatusSort::class);
        $this->assertIsEnum($modeHash, DestinyActivityModeType::class);
        $this->assertIsInt($page);
        $this->assertIsString($streamLocale);

        return $this->request('CommunityContent/Live/All/' . $partnershipType . '/' . $sort . '/' . $page)
            ->withParams([
                'modeHash' => $modeHash,
                'streamLocale' => $streamLocale
            ])
            ->get();
    }

    /**
     * @param $partnershipType
     * @param $sort
     * @param $page
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     * @throws InvalidInteger
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws HttpException
     */
    public function getCommunityLiveStatusesForClanmates($partnershipType, $sort, $page)
    {
        $this->assertIsEnum($partnershipType, PartnershipType::class);
        $this->assertIsEnum($sort, CommunityStatusSort::class);
        $this->assertIsInt($page);

        return $this->request('CommunityContent/Live/Clan/' . $partnershipType . '/' . $sort . '/' . $page)->get();
    }

    /**
     * @param $partnershipType
     * @param $sort
     * @param $page
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getCommunityLiveStatusesForFriends($partnershipType, $sort, $page)
    {
        $this->assertIsEnum($partnershipType, PartnershipType::class);
        $this->assertIsEnum($sort, CommunityStatusSort::class);
        $this->assertIsInt($page);

        return $this->request('CommunityContent/Live/Friends/' . $partnershipType . '/' . $sort . '/' . $page)->get();
    }

    /**
     * @param $partnershipType
     * @param $sort
     * @param $page
     * @param $streamLocale
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     * @throws InvalidInteger
     * @throws InvalidString
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws HttpException
     */
    public function getFeaturedCommunityLiveStatuses($partnershipType, $sort, $page, $streamLocale = 'ALL')
    {
        $this->assertIsEnum($partnershipType, PartnershipType::class);
        $this->assertIsEnum($sort, CommunityStatusSort::class);
        $this->assertIsInt($page);
        $this->assertIsString($streamLocale);

        return $this->request('CommunityContent/Live/Friends/' . $partnershipType . '/' . $sort . '/' . $page)->get();
    }

    /**
     * @param $partnershipType
     * @param $membershipType
     * @param $membershipId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws InvalidMembershipId
     */
    public function getStreamingStatusForMember($partnershipType, $membershipType, $membershipId)
    {
        $this->assertIsEnum($partnershipType, PartnershipType::class);
        $this->assertIsEnum($membershipType, BungieMembershipType::class);
        $this->assertIsMembershipId($membershipId);

        return $this->request('CommunityContent/Live/Users/' . $partnershipType . '/' . $membershipType . '/' . $membershipId)->get();
    }
}