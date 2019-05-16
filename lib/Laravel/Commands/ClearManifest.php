<?php

namespace AdamDBurton\Destiny2ApiClient\Laravel\Commands;

use Illuminate\Console\Command as LaravelCommand;

class ClearManifest extends LaravelCommand
{
    /**
     * @var string
     */
    protected $signature = 'destiny-2-api:cache:clear';

    /**
     * @var string
     */
    protected $description = 'Clears the Destiny 2 API manifest cache.';

    /**
     * @return mixed
     */
    public function handle()
    {
        $config = config('destiny2');
    }
}