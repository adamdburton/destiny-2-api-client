<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\Enum\DestinyComponentType;
use AdamDBurton\Destiny2ApiClient\Enum\ForumPostSort;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Enum\ForumTopicSort;
use AdamDBurton\Destiny2ApiClient\Enum\GroupDateRange;
use AdamDBurton\Destiny2ApiClient\Enum\GroupType;
use AdamDBurton\Destiny2ApiClient\Exception\Api\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidActivityType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidBoolean;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidCharacterId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidComponentType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidDestinyMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidEnum;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidEnumArray;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidForumPostSort;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidForumTopicCategoryFilter;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidForumTopicQuickDate;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidForumTopicSort;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupConversationId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupDateRange;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidGroupType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidItemActivityId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidItemHash;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidItemInstanceId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMembershipId;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMembershipType;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidMilestoneHash;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidString;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidVendorHash;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
abstract class Module
{
    protected $api;

    /**
     * ApiModule constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @param $token
     * @return $this
     */
    public function withAccessToken($token)
    {
        $this->api->getClient()->withAccessToken($token);

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutAccessToken()
    {
        $this->api->getClient()->withoutAccessToken();

        return $this;
    }

    /**
     * @return bool
     */
    public function hasAccessToken()
    {
        return $this->getClient()->hasAccessToken();
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->api->getClient();
    }

    /**
     * @param string|null $endpoint
     * @return Request
     */
    public function request(string $endpoint = null)
    {
        return $this->api->request()->withEndpoint($endpoint);
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getConfig($key, $default = null)
    {
        return $this->api->getConfig($key, $default);
    }

    /**
     * @param $membershipId
     * @throws InvalidMembershipId
     */
    public function assertIsMembershipId($membershipId)
    {
        if (!strlen(decbin(~$membershipId)) == 64) {
            throw new InvalidMembershipId($membershipId);
        }
    }

    /**
     * @param $destinyMembershipId
     * @throws InvalidDestinyMembershipId
     */
    protected function assertIsDestinyMembershipId($destinyMembershipId)
    {
        if (!strlen(decbin(~$destinyMembershipId)) == 64) {
            throw new InvalidDestinyMembershipId($destinyMembershipId);
        }
    }

    /**
     * @param $characterId
     * @throws InvalidCharacterId
     */
    protected function assertIsCharacterId($characterId)
    {
        if (!strlen(decbin(~$characterId)) == 64) {
            throw new InvalidCharacterId($characterId);
        }
    }

    /**
     * @param $groupId
     * @throws InvalidGroupId
     */
    protected function assertIsGroupId($groupId)
    {
        if (!strlen(decbin(~$groupId)) == 64) {
            throw new InvalidGroupId($groupId);
        }
    }

    /**
     * @param $itemInstanceId
     * @throws InvalidItemInstanceId
     */
    protected function assertIsItemInstanceId($itemInstanceId)
    {
        if (is_array($itemInstanceId)) {
            array_map([$this, __METHOD__], $itemInstanceId);
        } else {
            if (!strlen(decbin(~$itemInstanceId)) == 64) {
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
        if (!strlen(decbin(~$activityId)) == 64) {
            throw new InvalidItemActivityId($activityId);
        }
    }

    /**
     * @param $itemHash
     * @throws InvalidItemHash
     */
    protected function assertIsItemHash($itemHash)
    {
        if (!strlen(decbin(~$itemHash)) == 32) {
            throw new InvalidItemHash($itemHash);
        }
    }

    /**
     * @param $vendorHash
     * @throws InvalidVendorHash
     */
    protected function assertIsVendorHash($vendorHash)
    {
        if (!strlen(decbin(~$vendorHash)) == 32) {
            throw new InvalidVendorHash($vendorHash);
        }
    }

    /**
     * @param $milestoneHash
     * @throws InvalidMilestoneHash
     */
    protected function assertIsMilestoneHash($milestoneHash)
    {
        if (!strlen(decbin(~$milestoneHash)) == 32) {
            throw new InvalidMilestoneHash($milestoneHash);
        }
    }

    /**
     * @param $membershipType
     * @throws InvalidMembershipType
     */
    protected function assertIsMembershipType($membershipType)
    {
        if (!BungieMembershipType::hasEnum($membershipType)) {
            throw new InvalidMembershipType($membershipType);
        }
    }

    /**
     * @param $activityType
     * @throws InvalidActivityType
     */
    protected function assertIsActivityType($activityType)
    {
        if (is_array($activityType)) {
            array_map([$this, __METHOD__], $activityType);
        } else {
            if (!BungieMembershipType::hasEnum($activityType)) {
                throw new InvalidActivityType($activityType);
            }
        }
    }

    /**
     * @param $componentType
     * @throws InvalidComponentType
     */
    protected function assertIsComponentType($componentType)
    {
        if (is_array($componentType)) {
            array_map([$this, __METHOD__], $componentType);
        } else {
            if (!DestinyComponentType::hasEnum($componentType)) {
                throw new InvalidComponentType($componentType);
            }
        }
    }

    /**
     * @param $quickDate
     * @throws InvalidForumTopicQuickDate
     */
    protected function assertIsForumTopicQuickDate($quickDate)
    {
        if (!ForumTopicQuickDate::hasEnum($quickDate)) {
            throw new InvalidForumTopicQuickDate($quickDate);
        }
    }

    /**
     * @param $category
     * @throws InvalidForumTopicCategoryFilter
     */
    protected function assertIsForumTopicCategoryFilter($category)
    {
        if (!ForumTopicCategoryFilter::hasEnum($category)) {
            throw new InvalidForumTopicCategoryFilter($category);
        }
    }

    /**
     * @param $sort
     * @throws InvalidForumTopicSort
     */
    protected function assertIsForumTopicSort($sort)
    {
        if (!ForumTopicSort::hasEnum($sort)) {
            throw new InvalidForumTopicSort($sort);
        }
    }

    /**
     * @param $sort
     * @throws InvalidForumPostSort
     */
    protected function assertIsForumPostSort($sort)
    {
        if (!ForumPostSort::hasEnum($sort)) {
            throw new InvalidForumPostSort($sort);
        }
    }

    /**
     * @throws AccessTokenRequired
     */
    protected function assertHasAccessToken()
    {
        if (!$this->api->getClient()->hasAccessToken()) {
            throw new AccessTokenRequired;
        }
    }

    /**
     * @param $string
     * @throws InvalidString
     */
    public function assertIsString($string)
    {
        if(!is_string($string))
        {
            throw new InvalidString($string);
        }
    }
    /**
     * @param $boolean
     * @throws InvalidBoolean
     */
    public function assertIsBoolean($boolean)
    {
        if(!is_bool($boolean))
        {
            throw new InvalidBoolean($boolean);
        }
    }

    /**
     * @param $groupType
     * @throws InvalidGroupType
     */
    protected function assertIsGroupType($groupType)
    {
        if(!GroupType::hasEnum($groupType))
        {
            throw new InvalidGroupType($groupType);
        }
    }
    /**
     * @param $dateRange
     * @throws InvalidGroupDateRange
     */
    protected function assertIsGroupDateRange($dateRange)
    {
        if(!GroupDateRange::hasEnum($dateRange))
        {
            throw new InvalidGroupDateRange($dateRange);
        }
    }

    /**
     * @param $conversationId
     * @throws InvalidGroupConversationId
     */
    protected function assertIsGroupConversationId($conversationId)
    {
        if(!strlen(decbin(~$conversationId)) == 64)
        {
            throw new InvalidGroupConversationId($conversationId);
        }
    }

    /**
     * @param $value
     * @param $enumClass
     * @param bool $allowArray
     * @throws InvalidEnum
     * @throws InvalidEnumArray
     */
    public function assertIsEnum($value, Enum $enumClass, $allowArray = false)
    {
        $validEnum = !$enumClass::hasEnum($value);

        if($allowArray && !is_array($value) && $validEnum)
        {
            throw new InvalidEnum($value, $enumClass);
        }
        elseif($allowArray && is_array($value))
        {
            foreach($value as $item)
            {
                if(!$enumClass::hasEnum($item))
                {
                    throw new InvalidEnumArray($value, $enumClass);
                }
            }
        }
        elseif(!$validEnum)
        {
            throw new InvalidEnum($value, $enumClass);
        }
    }
    /**
     * @param $value
     * @param $enumClass
     * @throws InvalidEnumArray
     */
    public function assertIsEnumArray($value, $enumClass)
    {
        if(!is_array($value))
        {
            throw new InvalidEnumArray($value, $enumClass);
        }
    }

    /**
     * @param $int
     * @throws InvalidInteger
     */
    public function assertIsInt($int)
    {
        if(!is_int($int) || (is_int($int) && $int < 0))
        {
            throw new InvalidInteger($int);
        }
    }
}