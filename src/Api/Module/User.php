<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;

class User extends Module
{
	/**
	 * @param $membershipId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getBungieNetUserById($membershipId)
	{
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->get('User/GetBungieNetUserById/' . $membershipId);
	}

	/**
	 * @param $membershipId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getUserByAliases($membershipId)
	{
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->get('User/GetUserAliases/' . $membershipId);
	}

	/**
	 * @param $search
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function searchUsers($search)
	{
		return $this->apiClient->get('User/SearchUsers/', [ 'q' => $search ]);
	}

	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getAvailableThemes()
	{
		return $this->apiClient->get('User/GetAvailableThemes');
	}

	/**
	 * @param $membershipId
	 * @param $membershipType
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getMembershipDataById($membershipId, $membershipType)
	{
		$this->assertIsMembershipId($membershipId);
		$this->assertIsMembershipType($membershipType);

		return $this->apiClient->get('User/GetMembershipDataById/' . $membershipId . '/' . $membershipType);
	}

	/**
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getMembershipDataForCurrentUser()
	{
		$this->assertHasAccessToken();

		return $this->apiClient->get('User/GetMembershipsForCurrentUser');
	}

	/**
	 * @param $membershipId
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getPartnerships($membershipId)
	{
		$this->assertIsMembershipId($membershipId);

		return $this->apiClient->get('User/' . $membershipId . '/Partnerships');
	}
}