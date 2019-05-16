<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidManifestLanguage;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidManifestPath;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;
use PDO;
use ZipArchive;

class Exporter
{
    /**
     * @param $directory
     * @param string $language
     * @throws ApiKeyRequired
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws InvalidManifestLanguage
     * @throws InvalidManifestPath
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public static function asFiles($directory, $language = null)
    {
        $directory = rtrim($directory, '/');

        if(!is_dir($directory) || !$this->isDirectoryEmpty($directory)) {
            throw new InvalidManifestPath($directory);
        }

        $manifest = $this->getManifest($language);

        $temp = tempnam(sys_get_temp_dir(), 'D2');
        file_put_contents($temp, $manifest);

        $db = new PDO('sqlite:' . $temp);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $result = $db->query("SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name");

        foreach($result as $row)
        {
            $this->extractManifestFile($directory, $row['name'], $db);
        }
    }

    /**
     * @param $directory
     * @param $name
     * @param $pdo
     */
    protected function extractManifestFile($directory, $name, $pdo)
    {
        $data = [];

        $result = $pdo->query("SELECT * FROM $name");

        foreach($result as $row) {
            $data[$row->id] = $row->json;
        }

        file_put_contents($directory . '/' . $name, json_encode($data));
    }

    protected function isDirectoryEmpty($dir)
    {
        return is_readable($dir) && count(scandir($dir)) === 2;
    }

    /**
     * @param $url
     * @return string
     */
    protected function downloadManifest($url)
    {
        $manifestName = basename($url);

        $zip = file_get_contents('https://bungie.net' . $url);
        $temp = tempnam(sys_get_temp_dir(), 'D2');

        file_put_contents($temp, $zip);

        $zip = new ZipArchive;

        if($zip->open($temp) === TRUE)
        {
            return $zip->getFromName($manifestName);
        }

        return '';
    }
}