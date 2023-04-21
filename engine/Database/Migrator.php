<?php

namespace Engine\Database;

class Migrator
{
    public $migrations = [];
    public $tables = [];
    public $queries = [];

    public function table($name)
    {
        $this->tables[$name] = new Table($name);

        return $this->tables[$name];
    }

    public function setUpQueries()
    {
        foreach ($this->tables as $table) {
            $query = "CREATE TABLE {$table->name} (" . PHP_EOL;
            foreach ($table->columns as $column) {
                if (!isset($column['name']) || !isset($column['type'])) {
                    continue;
                }
                $query .= "{$column['name']} {$column['type']}";
                if (isset($column['max'])) {
                    $query .= "({$column['max']})";
                }
                if (isset($column['auto_increment'])) {
                    $query .= " AUTO_INCREMENT";
                }
                if (isset($column['primary'])) {
                    $query .= " PRIMARY KEY";
                }
                if (isset($column['nullable'])) {
                    $query .= " NULL";
                }
                $query .= "," . PHP_EOL;
            }
            $query = rtrim($query, ',' . PHP_EOL);
            $query .= PHP_EOL . ");" . PHP_EOL;
            $this->queries[] = $query;
            // echo $query . PHP_EOL . PHP_EOL;
        }
    }

    public function setDownQueries()
    {
        $query = '';
        foreach ($this->tables as $table) {
            $query .= "DROP TABLE {$table->name};" . PHP_EOL;
            $this->queries[] = $query;
        }
    }
}
