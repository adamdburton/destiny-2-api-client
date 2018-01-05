<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Api\Response;
use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\CommunityContentSortMode;
use AdamDBurton\Destiny2ApiClient\Enum\CommunityStatusSort;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyActivityModeType;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicsCategoryFilters;
use AdamDBurton\Destiny2ApiClient\Enum\PartnershipType;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidEnum;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidEnumArray;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidInteger;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidString;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class CommunityContent extends Module
{
	/**
	 * @param $sort
	 * @param $mediaFilter
	 * @param $page
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidInteger
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 */
	public function getCommunityContent($sort, $mediaFilter, $page)
	{
		$this->assertIsInt($page);
		$this->assertIsEnum($mediaFilter, ForumTopicsCategoryFilters::class);
		$this->assertIsEnum($sort, CommunityContentSortMode::class);

		return $this->apiClient->get('CommunityContent/Get/' . $sort . '/' . $mediaFilter . '/' . $page);
	}

	/**
	 * @param $partnershipType
	 * @param $sort
	 * @param $page
	 * @param $modeHash
	 * @param $streamLocale
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws InvalidInteger
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

		return $this->apiClient->get('CommunityContent/Live/All/' . $partnershipType . '/' . $sort . '/' . $page, [
			'modeHash' => $modeHash,
			'streamLocale' => $streamLocale
		]);
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
	 */
	public function getCommunityLiveStatusesForClanmates($partnershipType, $sort, $page)
	{
		$this->assertIsEnum($partnershipType, PartnershipType::class);
		$this->assertIsEnum($sort, CommunityStatusSort::class);
		$this->assertIsInt($page);

		return $this->apiClient->get('CommunityContent/Live/Clan/' . $partnershipType . '/' . $sort . '/' . $page);
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
	 */
	public function getCommunityLiveStatusesForFriends($partnershipType, $sort, $page)
	{
		$this->assertIsEnum($partnershipType, PartnershipType::class);
		$this->assertIsEnum($sort, CommunityStatusSort::class);
		$this->assertIsInt($page);

		return $this->apiClient->get('CommunityContent/Live/Friends/' . $partnershipType . '/' . $sort . '/' . $page);
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
	 */
	public function getFeaturedCommunityLiveStatuses($partnershipType, $sort, $page, $streamLocale = 'ALL')
	{
		$this->assertIsEnum($partnershipType, PartnershipType::class);
		$this->assertIsEnum($sort, CommunityStatusSort::class);
		$this->assertIsInt($page);
		$this->assertIsString($streamLocale);

		return $this->apiClient->get('CommunityContent/Live/Friends/' . $partnershipType . '/' . $sort . '/' . $page, [
			'streamLocale' => $streamLocale
		]);
	}

	/**
	 * @param $partnershipType
	 * @param $membershipType
	 * @param $membershipId
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws BadRequest
	 * @throws InvalidEnum
	 * @throws InvalidEnumArray
	 * @throws ResourceNotFound
	 * @throws Unauthorized
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 */
	public function getStreamingStatusForMember($partnershipType, $membershipType, $membershipId)
	{
		$this->assertIsEnum($partnershipType, PartnershipType::class);
		$this->assertIsEnum($membershipType, BungieMembershipType::class);
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->get('CommunityContent/Live/Users/' . $partnershipType . '/' . $membershipType . '/' . $membershipId);
	}
}