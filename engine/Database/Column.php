<?php

namespace Engine\Database;

class Column
{
    public $columns = [];
    public $currentColumn = '';

    public $columnTypes = [
        'id' => 'INT',
        'string' => 'VARCHAR',
        'integer' => 'INT',
        'boolean' => 'TINYINT',
        'datetime' => 'DATETIME',
        'text' => 'TEXT',
    ];

    public static function getColumnTypes()
    {
        $column = new self();

        return $column->columnTypes;
    }

    public function id()
    {
        $this->columns[] = [
            'name' => 'id',
            'type' => 'INT',
            'auto_increment' => true,
            'primary' => true,
        ];

        $this->currentColumn = 'id';

        return $this;
    }

    public function string($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'VARCHAR',
            'max' => 255,
        ];

        $this->currentColumn = $name;

        return $this;
    }

    public function integer($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'INT',
            'max' => 11,
        ];

        $this->currentColumn = $name;

        return $this;
    }

    public function boolean($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'TINYINT',
            'max' => 1,
        ];

        $this->currentColumn = $name;

        return $this;
    }

    public function datetime($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'DATETIME',
            'default' => 'CURRENT_TIMESTAMP',
        ];

        $this->currentColumn = $name;

        return $this;
    }

    public function text($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'TEXT',
        ];

        $this->currentColumn = $name;

        return $this;
    }

    public function timestamps()
    {
        $this->datetime('created_at');
        $this->datetime('updated_at');

        return $this;
    }

    public function foreignId($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'INT',
        ];

        $this->currentColumn = $name;

        return $this;
    }

    public function nullable()
    {
        $this->columns[$this->currentColumn]['nullable'] = true;

        return $this;
    }

    public function max($length)
    {
        $this->columns[$this->currentColumn]['length'] = $length;

        return $this;
    }
}
