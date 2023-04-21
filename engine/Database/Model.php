<?php

namespace Engine\Database;

class Model
{
    protected $table;

    public function __construct()
    {
        $this->table = $this->table ?? strtolower(str_replace('App\\Database\\Models\\', '', get_class($this)));
    }

    public static function getTableName()
    {
        return strtolower(str_replace('App\\Database\\Models\\', '', get_called_class()));
    }

    public static function all()
    {
        return DB::table(self::getTableName())->get();
    }

    public static function find($id)
    {
        return DB::table(self::getTableName())->find($id);
    }

    public static function create($data)
    {
        return DB::table(self::getTableName())->insert($data);
    }

    public static function update($id, $data)
    {
        return DB::table(self::getTableName())->where('id', $id)->update($data);
    }

    public static function delete($id)
    {
        return DB::table(self::getTableName())->where('id', $id)->delete();
    }
}
