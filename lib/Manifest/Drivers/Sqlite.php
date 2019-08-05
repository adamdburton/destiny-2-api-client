<?php /** @noinspection PhpUndefinedClassInspection */

namespace AdamDBurton\Destiny2ApiClient\Manifest\Drivers;

use AdamDBurton\Destiny2ApiClient\Manifest\Driver;
use AdamDBurton\Destiny2ApiClient\Util;
use PDO;
use PDOException;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest\Drivers
 */
class Sqlite extends Driver
{
    /** @var PDO */
    protected $db;

    /** @var string */
    protected $path;

    /**
     * @param $path
     * @return bool
     */
    public function load(string $path): bool
    {
        $this->path = $path;

        try {
            $db = new PDO(sprintf("sqlite:%s", $path));
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->db = $db;
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param string $type
     * @param string $hash
     * @return array|null
     */
    public function getDefinition($type, $hash): array
    {
        try {
            $key = $type === 'HistoricalStats' ? 'key' : 'id';

            $statement = $this->db->prepare(sprintf(sprintf("SELECT * FROM Destiny%sDefinition WHERE %s = ?", $type), $key));
            $statement->execute([$hash]);

            $row = $statement->fetch();

            return $row ? json_decode($row['json'], true) : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * @param string $type
     * @param int[] $hashes
     * @return array|null
     */
    public function getDefinitions($type, $hashes): array
    {
        $key = $type === 'HistoricalStats' ? 'key' : 'id';
        $params = substr(str_repeat('?, ', count($hashes)), 0, -1);

        try {
            $statement = $this->db->prepare(sprintf('SELECT * FROM Destiny' . $type . 'Definition WHERE %s IN (%s)', $key, $params));

            $statement->execute(implode(', ', $hashes));

            $definitions = [];

            foreach ($statement->fetch() as $row) {
                $definitions[$row->$key] = json_decode($row['json'], true);
            }

            return $definitions;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * @param string $table
     * @return bool
     */
    protected function tableExists(string $table): bool
    {
        try {
            $statement = $this->db->prepare("SELECT 1 FROM sqlite_master WHERE type = 'table' AND name = ?");
            $statement->execute($table);

            return !!$statement->rowCount();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param $path
     * @return bool $path
     */
    public function export(string $path): bool
    {
        try {
            $export = [];

            $statement = $this->db->prepare("SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name");
            $statement->execute($table);

            foreach ($statement->fetch() as $table) {
                $table = $table['name'];
                $data = [];

                $rows = $this->db->query("SELECT * FROM $table");

                foreach ($rows as $row) {
                    $key = isset($row['id']) ? Util::convertHash($row['id']) : $row['key'];
                    $data[$key] = $row['json'];
                }

                $export[$table] = $data;
            }

            return !!file_put_contents($path, json_encode($export));
        } catch (PDOException $e) {
            return false;
        }
    }
}