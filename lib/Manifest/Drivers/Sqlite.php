<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest\Drivers;

use AdamDBurton\Destiny2ApiClient\Api;
use AdamDBurton\Destiny2ApiClient\Exception\Manifest\DefinitionNotFound;
use AdamDBurton\Destiny2ApiClient\Manifest\Driver;
use PDO;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest\Drivers
 */
class Sqlite extends Driver
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Sqlite constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $db = new PDO('sqlite:' . $filename);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->db = $db;
    }

    /**
     * @param string $type
     * @param string $hash
     * @return \stdClass|void
     * @throws DefinitionNotFound
     */
    public function getDefinition($type, $hash)
    {
        $key = $type == 'HistoricalStats' ? 'key' : 'id';

        $statement = $this->db->prepare(sprintf('SELECT * FROM Destiny' . $type . 'Definition WHERE %s = ?', $key));
        $statement->execute([$hash]);

        $row = $statement->fetch();

        if (!$row) {
            throw new DefinitionNotFound($type, $hash);
        }

        return json_decode($row['json'], true);
    }

    /**
     * @param string $type
     * @param array|int[] $hashes
     * @return \stdClass[]
     * @throws DefinitionNotFound
     */
    public function getDefinitions($type, $hashes)
    {
        $key = $type == 'HistoricalStats' ? 'key' : 'id';
        $hashes = implode(', ', $hashes);
        $params = substr(str_repeat('?,', count($hashes)), 0, -1);

        $statement = $this->db->prepare(sprintf('SELECT * FROM Destiny' . $type . 'Definition WHERE %s IN (%s)', $key, $params));
        $statement->execute($hashes);

        $rows = $statement->fetch();

        $definitions = [];

        foreach($rows as $row) {
            $definitions[$row->$key] = json_decode($row['json'], true);
        }

        return $definitions;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function export(string $path): bool
    {
        $path = rtrim($path, '/');

        $result = $this->db->query("SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name");

        foreach($result as $table)
        {
            $table = $table['name'];
            $data = [];

            $rows = $this->db->query("SELECT * FROM $table");

            foreach($rows as $row) {
                $key = isset($row['id']) ? Api::convertHash($row['id']) : $row['key'];
                $data[$key] = $row['json'];
            }

            file_put_contents(sprintf('%s/%s.json', $path, $table), json_encode($data));
        }

        return true;
    }

    /**
     * @param $directory
     * @param $name
     * @param $pdo
     */
    protected function exportManifestFile($directory, $name)
    {

    }
}