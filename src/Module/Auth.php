<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Response;
use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class Auth extends Module
{
    protected static $REDIRECT_URL = 'https://www.bungie.net/en/OAuth/Authorize';

    public function getRedirectUrl($oAuthClientId = null)
    {
        $clientId = $this->getConfig('client_id', $oAuthClientId);

        return sprintf('%s?client_id=%s&response_type=code', self::$REDIRECT_URL, $clientId);
    }

    /**
     * @param $authCode
     * @param $oAuthClientId
     * @param $oAuthClientSecret
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getAccessTokenFromAuthCode($authCode, $oAuthClientId = null, $oAuthClientSecret = null)
    {
        $clientId = $this->getConfig('client_id', $oAuthClientId);
        $clientSecret = $this->getConfig('client_secret', $oAuthClientSecret);

        return $this->apiClient->postAsForm('App/OAuth/Token', ['code' => $authCode, 'grant_type' => 'authorization_code'], [
            'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret)
        ]);
    }

    /**
     * @param $refreshToken
     * @param $oAuthClientId
     * @param $oAuthClientSecret
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getAccessTokenFromRefreshToken($refreshToken, $oAuthClientId, $oAuthClientSecret)
    {
        $clientId = $this->getConfig('client_id', $oAuthClientId);
        $clientSecret = $this->getConfig('client_secret', $oAuthClientSecret);

        return $this->apiClient->postAsForm('App/OAuth/Token', ['refresh_token' => $refreshToken, 'grant_type' => 'refresh_token'], [
            'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret)
        ]);
    }
}