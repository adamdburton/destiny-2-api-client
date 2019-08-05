# PHP API client for Destiny 2

[![Packagist](https://img.shields.io/packagist/v/adamdburton/destiny-2-api-client.svg)](https://packagist.org/packages/adamdburton/destiny-2-api-client)

## API Documentation

Endpoint documentation is available at https://bungie-net.github.io/multi/

### Usage

Visit https://www.bungie.net/en/Application to obtain an API key. Some endpoints require an access token to perform actions on behalf of users which can be obtained by redirecting users to Bungie's OAuth server. The Auth module can assist with .

#### Examples

``` php
<?php

use AdamDBurton\Destiny2ApiClient\Api;

$api = new Api('{api-key}');

$api->destiny2()
    ->getDestinyManifest();

$api->user()
    ->withAccessToken('{oauth-token}')
    ->getMembershipDataForCurrentUser();
```

### Modules

The API is split into modules, similarly to the API itself. Each method in a module maps one-to-one to end endpoint in the API.

##### App

```
$api->app()->getBungieApplications()
$api->app()->getApplicationApiUsage(string $applicationId)
```

##### Destiny2

```

```

#### User
`$api->user()`

##### Forum
`$api->forum()`

##### GroupV2
`$api->groupV2()`

##### CommunityContent
`$api->communityContent()`

##### Trending
`$api->trending()`