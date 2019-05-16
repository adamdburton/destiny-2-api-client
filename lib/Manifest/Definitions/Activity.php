<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest\Definitions;

use AdamDBurton\Destiny2ApiClient\Manifest\Definition;

class Activity extends Definition
{
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
