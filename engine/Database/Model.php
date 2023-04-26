<?php

namespace Engine\Database;

use Engine\Database\DB;

class Model
{
    /**
     * Database table name.
     * 
     * @var string
     */
    protected $table;

    /**
     * Database primary key.
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Get database table name.
     * 
     * @return string
     */
    public function getTableName()
    {
        return $this->table ?? (string) str(basename(str_replace('\\', '/', get_class($this))))->snakeCase()->plural();
    }

    /**
     * Get all data from database table.
     * 
     * @return array
     */
    public static function all()
    {
        return DB::table((new static)->getTableName())->all();
    }

    /**
     * Get data from database table by primary key.
     * 
     * @param string $key
     * @return array
     */
    public static function find($key)
    {
        return DB::table((new static)->getTableName())->select()->where([(new static)->primaryKey => $key])->get(true);
    }

    /**
     * Get data from database table by where clause.
     * 
     * @param array $where
     * @return array
     */
    public static function where(array $where)
    {
        return DB::table((new static)->getTableName())->select()->where($where);
    }

    /**
     * Insert data to database table.
     * 
     * @param array $data
     * @return bool
     */
    public static function insert(array $data)
    {
        return DB::table((new static)->getTableName())->insert($data);
    }

    /**
     * Update data from database table.
     * 
     * @param array $data
     * @param array $where
     * @return bool
     */
    public static function update(array $data, array $where)
    {
        return DB::table((new static)->getTableName())->where($where)->update($data);
    }

    /**
     * Delete data from database table.
     * 
     * @param array $where
     * @return bool
     */
    public static function delete(array $where)
    {
        return DB::table((new static)->getTableName())->where($where)->delete();
    }

    /**
     * Call static method.
     * 
     * @param string $method
     * @param array $args
     */
    public static function __callStatic($method, $args)
    {
        return DB::table((new static)->getTableName())->$method(...$args);
    }
}
