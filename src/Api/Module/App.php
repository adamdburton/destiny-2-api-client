<?php

namespace AdamDBurton\Destiny2ApiClient\Api\Module;

use AdamDBurton\Destiny2ApiClient\Api\Module;

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
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
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
	 * @return \AdamDBurton\Destiny2ApiClient\Api\Response
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 */
	public function getAccessTokenFromRefreshToken($refreshToken, $oAuthClientId, $oAuthClientSecret)
	{
		return $this->apiClient->postAsForm('App/OAuth/Token', [ 'refresh_token' => $refreshToken, 'grant_type' => 'refresh_token' ], [
			'Authorization' => 'Basic ' . base64_encode($oAuthClientId . ':' . $oAuthClientSecret)
		]);
	}
}