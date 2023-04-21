<?php

namespace Engine\Helper;

class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function forEach(callable $callback)
    {
        foreach ($this->items as $key => $value) {
            if ($callback($value, $key) === false) {
                break;
            }
        }
    }

    public function map(callable $callback)
    {
        $result = [];

        foreach ($this->items as $key => $value) {
            $result[$key] = $callback($value, $key);
        }

        return new static($result);
    }

    public function filter(callable $callback)
    {
        $result = [];

        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                $result[$key] = $value;
            }
        }

        return new static($result);
    }

    public function toArray()
    {
        return $this->items;
    }

    public function toJson()
    {
        return json_encode($this->items);
    }
}
