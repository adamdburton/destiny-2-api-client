<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;
use AdamDBurton\Destiny2ApiClient\Api\Response;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;

class App extends Module
{
	/**
	 * @param $oAuthClientId
	 * @return string
	 */
	public function getRedirectUrl($oAuthClientId)
	{
		return sprintf('https://www.bungie.net/en/OAuth/Authorize?client_id=%s&response_type=code', $oAuthClientId);
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
	 */
	public function getAccessTokenFromAuthCode($authCode, $oAuthClientId, $oAuthClientSecret)
	{
		return $this->apiClient->postAsForm('App/OAuth/Token', [ 'code' => $authCode, 'grant_type' => 'authorization_code' ], [
			'Authorization' => 'Basic ' . base64_encode($oAuthClientId . ':' . $oAuthClientSecret)
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
	 */
	public function getAccessTokenFromRefreshToken($refreshToken, $oAuthClientId, $oAuthClientSecret)
	{
		return $this->apiClient->postAsForm('App/OAuth/Token', [ 'refresh_token' => $refreshToken, 'grant_type' => 'refresh_token' ], [
			'Authorization' => 'Basic ' . base64_encode($oAuthClientId . ':' . $oAuthClientSecret)
		]);
	}
}