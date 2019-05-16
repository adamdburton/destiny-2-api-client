<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Exception\AccessTokenRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class App extends Module
{
    /**
     * @param $applicationId
     * @return Response
     * @throws ApiKeyRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws AccessTokenRequired
     */
    public function getApplicationApiUsage($applicationId)
    {
        $this->assertHasAccessToken();

        return $this->apiClient->get('App/ApiUsage/' . $applicationId);
    }

    /**
     * @return Response
     * @throws ApiKeyRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function getBungieApplications()
    {
        return $this->apiClient->get('App/FirstParty');
    }


}