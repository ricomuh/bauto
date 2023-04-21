<?php

namespace Engine\Database;

class Table
{
    public $name = '';
    public $columns = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function create($callback)
    {
        $columns = new Column();
        $callback($columns);

        $this->columns = $columns->columns;
    }
}
