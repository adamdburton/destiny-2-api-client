<?php /** @noinspection PhpUndefinedClassInspection */

namespace AdamDBurton\Destiny2ApiClient;

use Closure;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
class Collection
{
    /**
     * @var array
     */
    protected $items;

    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param array $items
     * @return Collection
     */
    public static function make(array $items = [])
    {
        return new static($items);
    }

    /**
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = $default;

        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        if ($key === '*') {
            return $this->items;
        }

        $items = $this->items;
        $keys = explode('.', $key);

        foreach ($keys as $i => $segment) {
            if(!isset($items[$segment]) && $segment === '*') {
                $value = (new static($items))->pluck(implode('.', array_slice($keys, $i + 1)))->all();
                break;
            } elseif (isset($items[$segment])) {
                $value = $items = $items[$segment];
            } else {
                $value = $default;
                break;
            }
        }

        return $value;
    }

    /**
     * @param mixed $key
     * @return Collection
     */
    public function pluck($key)
    {
        return $this->map(function($item) use ($key) {
            return (new static($item))->get($key);
        });
    }

    /**
     * @param Closure $callback
     * @return Collection
     */
    public function map(Closure $callback)
    {
        return new static(array_map($callback, $this->items));
    }

    /**
     * @param Closure $callback
     * @return $this
     */
    public function each(Closure $callback)
    {
        array_map($callback, $this->items);

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @return Collection
     */
    public function flatten()
    {
        $items = [];

        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->items));

        foreach($iterator as $item) {
            $items[] = $item;
        }

        return new static($items);
    }

    /**
     * @param array $keys
     * @return Collection
     */
    public function only(array $keys)
    {
        $items = [];

        foreach ($this->items as $i => $key) {
            if(in_array($i, $keys)) {
                $items[$i] = $keys;
            }
        }

        return new static($items);
    }
}