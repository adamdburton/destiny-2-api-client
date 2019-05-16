<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Contract\Middleware as MiddlewareContract;
use AdamDBurton\Destiny2ApiClient\Exception\Api\InvalidMiddleware;
use Closure;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
class Middleware implements MiddlewareContract
{
    /** @var MiddlewareContract[] */
    protected $middleware = [];

    /**
     * @var Api
     */
    protected $api;

    public function __construct(array $middleware = [])
    {
        $this->middleware = $middleware;
    }

    /**
     * @param Api $api
     * @return $this
     */
    public function withApi(Api $api): Middleware
    {
        $this->api = $api;

        return $this;
    }

    /**
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->api;
    }

    /**
     * @param $middleware
     * @return Middleware
     * @throws InvalidMiddleware
     */
    public function middleware($middleware)
    {
        if ($middleware instanceof Middleware) {
            $middleware = $middleware->toArray();
        }

        if ($middleware instanceof MiddlewareContract) {
            $middleware = [$middleware];
        }

        if (!is_array($middleware)) {
            throw new InvalidMiddleware($middleware);
        }

        return new static(array_merge($this->middleware, $middleware));
    }

    /**
     * @param mixed $payload
     * @param Closure $next
     * @return mixed
     */
    public function handle($payload, Closure $next)
    {
        $coreFunction = $this->createCoreFunction($next);

        $middleware = array_reverse($this->middleware);

        $complete = array_reduce($middleware, function ($nextMiddleware, $middleware) {
            return $this->createMiddleware($nextMiddleware, $middleware);
        }, $coreFunction);

        return $complete($payload);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->middleware;
    }

    /**
     * @param Closure $next
     * @return Closure
     */
    private function createCoreFunction(Closure $next)
    {
        return function ($payload) use ($next) {
            return $next($payload);
        };
    }

    /**
     * @param $nextMiddleware
     * @param $middleware
     * @return Closure
     */
    private function createMiddleware($nextMiddleware, $middleware)
    {
        return function ($payload) use ($nextMiddleware, $middleware) {
            return $middleware->handle($payload, $nextMiddleware);
        };
    }

}
