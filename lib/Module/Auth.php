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
class Auth extends Module
{
    protected static $REDIRECT_URL = 'https://www.bungie.net/en/OAuth/Authorize';

    /**
     * @param string $oAuthClientId
     * @return string
     */
    public function getRedirectUrl(string $oAuthClientId = null)
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
     * @throws HttpException
     */
    public function getAccessTokenFromAuthCode($authCode, $oAuthClientId = null, $oAuthClientSecret = null)
    {
        $clientId = $this->getConfig('client_id', $oAuthClientId);
        $clientSecret = $this->getConfig('client_secret', $oAuthClientSecret);

        return $this->request('App/OAuth/Token')
            ->withParams(['code' => $authCode, 'grant_type' => 'authorization_code'])
            ->withHeaders(['Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret)])
            ->postAsForm();
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
     * @throws HttpException
     */
    public function getAccessTokenFromRefreshToken($refreshToken, $oAuthClientId, $oAuthClientSecret)
    {
        $clientId = $this->getConfig('client_id', $oAuthClientId);
        $clientSecret = $this->getConfig('client_secret', $oAuthClientSecret);

        return $this->request('App/OAuth/Token')
            ->withParams(['refresh_token' => $refreshToken, 'grant_type' => 'refresh_token'])
            ->withBody(['Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret)])
            ->postAsForm();
    }
}