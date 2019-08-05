<?php

namespace AdamDBurton\Destiny2ApiClient\Response\Destiny2;

use AdamDBurton\Destiny2ApiClient\Manifest\Definitions\Activity;
use AdamDBurton\Destiny2ApiClient\Response;

/**
 * @package AdamDBurton\Destiny2ApiClient\Response\Destiny2
 */
class ActivityHistory extends Response
{
    /**
     * @param array $json
     * @return array
     */
    public function transform($json)
    {
        return $json['activities'];
    }

    /**
     * Used by the InjectDefinitions middleware to add manifest definitions to API responses
     *
     * @return array
     */
    public function definitionMappings()
    {
        return [
            'activity' => [
                'class' => Activity::class,
                'identifier' => '*.activityDetails.referenceId'
            ]
        ];
    }
}