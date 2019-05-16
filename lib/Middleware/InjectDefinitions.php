<?php

namespace AdamDBurton\Destiny2ApiClient\Middleware;

use AdamDBurton\Destiny2ApiClient\Middleware;
use Closure;

/**
 * @package AdamDBurton\Destiny2ApiClient\Middleware
 */
class InjectDefinitions extends Middleware
{
    /**
     * @param mixed $payload
     * @param Closure $next
     * @return mixed
     */
    public function handle($payload, Closure $next)
    {
        $payload = $next($payload);

        return $this->injectDefinitions($payload);
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function injectDefinitions($response)
    {
        $this->setupDefinitions();

        $api = $this->getApi();

        if (!$api->hasManifest()) {

        }

        return $response;
    }

    protected function mapDefinitions($json)
    {
        if (!$this->manifest || !method_exists($this, 'definitionMappings')) {
            return $json;
        }

        $mappings = $this->definitionMappings();

        $data = dot($json);

        foreach ($mappings as $alias => $definition) {
            if (substr($definition['identifier'], 0, 1) === '*') {
                // First char of the hash is *, must be an array
                $identifier = substr($definition['identifier'], 2);
                $values = [];

                foreach ($json as $i => $object) {
                    $values[$i] = dot($object)->get($identifier);
                }

                $type = basename(str_replace('\\', '/', $definition['class']));

                $data = $this->mapDefinitionsToData(
                    $data,
                    $type,
                    $this->manifest->getDefinitions($type, $values),
                    $identifier
                );

                dd($data);
            } else {
                dd($data->get($definition['hash']));
            }
        }

//        dd($data);

//        $this->m

        return $json;
    }

    protected function mapDefinitionsToData($data, $type, $definitions, $identifier)
    {
        foreach ($data as $i => $row) {
            $dot = dot($data);

            if ($dot->has($identifier)) {
                $id = $dot->get($identifier);

                if (!isset($data['definitions'])) {
                    $data[$i]['definitions'] = [];
                }

                $data[$i]['definitions'][$type] = $definitions[$id];
            }
        }

        return $data;
    }
}