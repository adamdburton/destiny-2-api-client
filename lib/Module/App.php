<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;

/**
 * @package AdamDBurton\Destiny2ApiClient\Module
 */
class App extends Module
{
    /**
     * @param $applicationId
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws HttpException
     */
    public function getApplicationApiUsage($applicationId)
    {
        $this->assertHasAccessToken();

        return $this->request()
            ->endpoint('App/ApiUsage/' . $applicationId)
            ->get();
    }

    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws HttpException
     */
    public function getBungieApplications()
    {
        return $this->request()
            ->endpoint('App/FirstParty')
            ->get();
    }


}