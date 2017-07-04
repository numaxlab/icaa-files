<?php

namespace NumaxLab\Icaa\Records;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use NumaxLab\Icaa\Exceptions\RecordsCollectionException;

class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * Collection constructor.
     * @param array $items
     * @throws \NumaxLab\Icaa\Exceptions\RecordsCollectionException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if (! $item instanceof RecordInterface) {
                throw new RecordsCollectionException(sprintf("Invalid provided item. Each item must implement %s", RecordInterface::class));
            }
        }

        $this->items = $items;
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Execute a callback over each item.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }
        return $this;
    }

    /**
     * Remove an item from the collection by key.
     *
     * @param  string|array  $keys
     * @return $this
     */
    public function forget($keys)
    {
        foreach ((array) $keys as $key) {
            $this->offsetUnset($key);
        }
        return $this;
    }

    /**
     * Get an item from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \NumaxLab\Icaa\Records\RecordInterface
     */
    public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Determine if the collection is not empty.
     *
     * @return bool
     */
    public function isNotEmpty()
    {
        return ! $this->isEmpty();
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param  mixed  $key
     * @param  \NumaxLab\Icaa\Records\RecordInterface  $value
     * @return $this
     */
    public function put($key, RecordInterface $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param  \NumaxLab\Icaa\Records\RecordInterface  $value
     * @return $this
     */
    public function push(RecordInterface $value)
    {
        $this->offsetSet(null, $value);

        return $this;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}
