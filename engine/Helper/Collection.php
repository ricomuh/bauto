<?php

namespace Engine\Helper;

class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $items = [];

    /**
     * Collection constructor.
     * 
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        // $itemsToSet = [];

        // foreach ($items as $key => $value) {
        //     if (is_array($value)) {
        //         $itemsToSet[$key] = new static($value);
        //     } else {
        //         $itemsToSet[$key] = $value;
        //     }
        // }

        // $this->items = $itemsToSet;
        $this->items = $items;
    }

    /**
     * @param array $items
     * @return static
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * This method is used to foreach collection
     * 
     * @param $callback callable
     * @return void
     */
    public function forEach(callable $callback): void
    {
        foreach ($this->items as $key => $value) {
            if ($callback($value, $key) === false) {
                break;
            }
        }
    }

    /**
     * This method is used to map collection
     * 
     * @param $callback callable
     * @return Collection
     */
    public function map(callable $callback): Collection
    {
        $result = [];

        foreach ($this->items as $key => $value) {
            $result[$key] = $callback($value, $key);
        }

        return new static($result);
    }

    /**
     * This method is used to filter collection
     * 
     * @param $callback callable
     * @return Collection
     */
    public function filter(callable $callback): Collection
    {
        $result = [];

        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                $result[$key] = $value;
            }
        }

        return new static($result);
    }

    /**
     * This method is used to convert collection to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->items as $key => $value) {
            if ($value instanceof static) {
                $result[$key] = $value->toArray();
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * This method is used to convert collection to json string
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * This method is used to convert collection to string
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * This method is used to add item to collection
     * 
     * @param $item
     * @return void
     */
    public function add($item): void
    {
        if (is_array($item)) {
            $item = new static($item);
        } elseif ($item instanceof static) {
            $item = $item->all();
        }

        $this->items[] = $item;
    }

    /**
     * This method is used to add custom method to collection class
     * 
     * @param $method string
     * @param $callback callable
     */
    public function addMethod($method, $callback)
    {
        $this->$method = $callback;
    }
}
