<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest\Definitions;

use AdamDBurton\Destiny2ApiClient\Manifest\Definition;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest\Definitions
 */
class Activity extends Definition
{
    /**
     * @return array
     */
    public function definitionMappings()
    {
        return [
            'destinationHash' => [
                'definition' => Destination::class,
                'as' => 'destination'
            ]
        ];
    }
}
