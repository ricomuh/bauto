<?php

namespace Engine\Helper;

class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $itemsToSet = [];

        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $itemsToSet[$key] = new static($value);
            } else {
                $itemsToSet[$key] = $value;
            }
        }

        $this->items = $itemsToSet;
    }

    public function all()
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
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

    public function toJson()
    {
        return json_encode($this->items);
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function add($item)
    {
        if (is_array($item)) {
            $item = new static($item);
        } elseif ($item instanceof static) {
            $item = $item->all();
        }

        $this->items[] = $item;
    }
}
