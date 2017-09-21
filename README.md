# PHP API client for Destiny 2

[![Packagist](https://img.shields.io/packagist/v/adamdburton/destiny-2-api-client.svg)](https://packagist.org/packages/adamdburton/destiny-2-api-client)

## API Documentation

Endpoint documentation is available at https://bungie-net.github.io/multi/

## Usage

You will need an API key from https://www.bungie.net/en/Application and some endpoints require access tokens (available by logging in through Bungie oAuth - see https://lowlidev.com.au/destiny/authentication-2 for authentiation flow examples)

```
$api = new \AdamDBurton\Destiny2ApiClient\Api('{api-key}');
```

## Modules

#### App
Implementation - https://github.com/adamdburton/destiny-2-api-client/blob/master/src/Api/Module/App.php
Accessed through - `$api->app()`

#### Destiny2
Implementation - https://github.com/adamdburton/destiny-2-api-client/blob/master/src/Api/Module/Destiny2.php
Accessed through - `$api->destiny2()`

#### User
Implementation - https://github.com/adamdburton/destiny-2-api-client/blob/master/src/Api/Module/User.php
Accessed through - `$api->user()`

#### Forum
Not yet implemented

#### GroupV2
Not yet implemented

#### CommunityContent
Not yet implemented

#### Trending
Not yet implemented

## oAuth

Some endpoints require an oAuth token with applicable scope permissions.

`$api->user()->withAccessToken('{oauth-token}')->getMembershipDataForCurrentUser();`
