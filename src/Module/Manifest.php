<?php

namespace AdamDBurton\Destiny2ApiClient\Module;

use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidManifestPath;
use AdamDBurton\Destiny2ApiClient\Module;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidManifestLanguage;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;
use PDO;
use ZipArchive;

class Manifest extends Module
{
    /**
     * @param string $language
     * @return bool|false|string
     * @throws InvalidManifestLanguage
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function getManifest($language = 'en')
    {
        $destiny2 = new Destiny2($this->apiClient);
        $manifest = $destiny2->getDestinyManifest()->json();

        if(!isset($manifest->mobileWorldContentPaths->$language))
        {
            throw new InvalidManifestLanguage($language);
        }

        return $this->downloadManifest($manifest->mobileWorldContentPaths->$language);
    }


}