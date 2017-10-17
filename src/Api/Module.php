<?php

namespace AdamDBurton\Destiny2ApiClient\Api;

use AdamDBurton\Destiny2ApiClient\Enum\Component;
use AdamDBurton\Destiny2ApiClient\Enum\ForumPostSort;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicSort;
use AdamDBurton\Destiny2ApiClient\Enum\Membership;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidActivityType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidCharacterId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidComponentType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidDestinyMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumPostSort;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidForumTopicSort;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemActivityId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemHash;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidItemInstanceId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidMilestoneHash;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidVendorHash;

abstract class Module
{
	protected $apiClient;

	/**
	 * ApiModule constructor.
	 * @param Client $apiClient
	 */
	public function __construct(Client $apiClient)
	{
		$this->apiClient = $apiClient;
	}

	/**
	 * @param $token
	 * @return $this
	 */
	public function withAccessToken($token)
	{
		$this->apiClient->withAccessToken($token);

		return $this;
	}

	/**
	 * @return $this
	 */
	public function withoutAccessToken()
	{
		$this->apiClient->withoutAccessToken();

		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasAccessToken()
	{
		return $this->apiClient->hasAccessToken();
	}

	/**
	 * @param $membershipId
	 * @throws InvalidMembershipId
	 */
	public function assertIsMembershipId($membershipId)
	{
		if(!strlen(decbin(~$membershipId)) == 64)
		{
			throw new InvalidMembershipId($membershipId);
		}
	}

	/**
	 * @param $destinyMembershipId
	 * @throws InvalidDestinyMembershipId
	 */
	protected function assertIsDestinyMembershipId($destinyMembershipId)
	{
		if(!strlen(decbin(~$destinyMembershipId)) == 64)
		{
			throw new InvalidDestinyMembershipId($destinyMembershipId);
		}
	}

	/**
	 * @param $characterId
	 * @throws InvalidCharacterId
	 */
	protected function assertIsCharacterId($characterId)
	{
		if(!strlen(decbin(~$characterId)) == 64)
		{
			throw new InvalidCharacterId($characterId);
		}
	}

	/**
	 * @param $groupId
	 * @throws InvalidGroupId
	 */
	protected function assertIsGroupId($groupId)
	{
		if(!strlen(decbin(~$groupId)) == 64)
		{
			throw new InvalidGroupId($groupId);
		}
	}

	/**
	 * @param $itemInstanceId
	 * @throws InvalidItemInstanceId
	 */
	protected function assertIsItemInstanceId($itemInstanceId)
	{
		if(is_array($itemInstanceId))
		{
			array_map([ $this, __METHOD__ ], $itemInstanceId);
		}
		else
		{
			if(!strlen(decbin(~$itemInstanceId)) == 64)
			{
				throw new InvalidItemInstanceId($itemInstanceId);
			}
		}
	}

	/**
	 * @param $activityId
	 * @throws InvalidItemActivityId
	 */
	protected function assertIsActivityId($activityId)
	{
		if(!strlen(decbin(~$activityId)) == 64)
		{
			throw new InvalidItemActivityId($activityId);
		}
	}

	/**
	 * @param $itemHash
	 * @throws InvalidItemHash
	 */
	protected function assertIsItemHash($itemHash)
	{
		if(!strlen(decbin(~$itemHash)) == 32)
		{
			throw new InvalidItemHash($itemHash);
		}
	}

	/**
	 * @param $vendorHash
	 * @throws InvalidVendorHash
	 */
	protected function assertIsVendorHash($vendorHash)
	{
		if(!strlen(decbin(~$vendorHash)) == 32)
		{
			throw new InvalidVendorHash($vendorHash);
		}
	}

	/**
	 * @param $milestoneHash
	 * @throws InvalidMilestoneHash
	 */
	protected function assertIsMilestoneHash($milestoneHash)
	{
		if(!strlen(decbin(~$milestoneHash)) == 32)
		{
			throw new InvalidMilestoneHash($milestoneHash);
		}
	}

	/**
	 * @param $membershipType
	 * @throws InvalidMembershipType
	 */
	protected function assertIsMembershipType($membershipType)
	{
		if(!Membership::hasEnum($membershipType))
		{
			throw new InvalidMembershipType($membershipType);
		}
	}

	/**
	 * @param $activityType
	 * @throws InvalidActivityType
	 */
	protected function assertIsActivityType($activityType)
	{
		if(is_array($activityType))
		{
			array_map([ $this, __METHOD__ ], $activityType);
		}
		else
		{
			if(!Membership::hasEnum($activityType))
			{
				throw new InvalidActivityType($activityType);
			}
		}
	}

	protected function assertIsComponentType($componentType)
	{
		if(is_array($componentType))
		{
			array_map([ $this, __METHOD__ ], $componentType);
		}
		else
		{
			if(!Component::hasEnum($componentType))
			{
				throw new InvalidComponentType($componentType);
			}
		}
	}

	protected function assertIsForumTopicQuickDate($quickDate)
	{
		if(!ForumTopicQuickDate::hasEnum($quickDate))
		{
			throw new InvalidForumTopicQuickDate($quickDate);
		}
	}

	protected function assertIsForumTopicCategoryFilter($category)
	{
		if(!ForumTopicCategoryFilter::hasEnum($category))
		{
			throw new InvalidForumTopicCategoryFilter($category);
		}
	}

	protected function assertIsForumTopicSort($sort)
	{
		if(!ForumTopicSort::hasEnum($sort))
		{
			throw new InvalidForumTopicSort($sort);
		}
	}

	protected function assertIsForumPostSort($sort)
	{
		if(!ForumPostSort::hasEnum($sort))
		{
			throw new InvalidForumPostSort($sort);
		}
	}

	/**
	 * @throws AccessTokenRequired
	 */
	protected function assertHasAccessToken()
	{
		if(!$this->apiClient->hasAccessToken())
		{
			throw new AccessTokenRequired;
		}
	}
}