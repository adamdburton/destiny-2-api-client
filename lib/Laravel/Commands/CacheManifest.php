<?php

namespace AdamDBurton\Destiny2ApiClient\Laravel\Commands;

use Illuminate\Console\Command as LaravelCommand;

/**
 * @package AdamDBurton\Destiny2ApiClient\Laravel\Commands
 */
class CacheManifest extends LaravelCommand
{
    /**
     * @var string
     */
    protected $signature = 'destiny-2-api:cache';

    /**
     * @var string
     */
    protected $description = 'Refreshes the Destiny 2 API manifest cache.';

    /**
     * @return mixed
     */
    public function handle()
    {

    }
}