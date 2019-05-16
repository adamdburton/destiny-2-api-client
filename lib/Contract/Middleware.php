<?php

namespace AdamDBurton\Destiny2ApiClient\Contract;

use Closure;

/**
 * @package AdamDBurton\Destiny2ApiClient\Contract
 */
interface Middleware
{
    /**
     * @param $payload
     * @param Closure $next
     * @return mixed
     */
    public function handle($payload, Closure $next);
}