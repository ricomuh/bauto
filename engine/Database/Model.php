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
     * The hidden attributes.
     * 
     * @var array
     */
    protected $hidden = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    protected $timestamps = false;

    /**
     * The value of the model's primary key.
     * 
     * @var mixed
     */
    private $oldPrimaryKeyValue;


    /**
     * Indicates if the model exists in database.
     * 
     * @var bool
     */
    protected $exists = false;

    /**
     * The model's attributes.
     * 
     * @var array
     */
    protected $columns = [];


    /**
     * Create new model instance.
     * 
     * @param array $data
     */
    public function __construct(bool $exists = false, array $data = [], bool $isAlreadyFetched = false)
    {
        // dd($exists, $data, $isAlreadyFetched);
        if ($isAlreadyFetched) {
            $this->exists = true;
            $this->fill($data);
            return;
        }
        // dd($data);
        // $this->exists = $exists;
        if ($exists) {
            $find = static::find($data[$this->primaryKey]);
            // dd($find);
            if ($find) {
                $this->exists = true;
                foreach ($find->columns as $value) {
                    $this->$value = $find->$value;
                }
                $this->oldPrimaryKeyValue = $find->oldPrimaryKeyValue;
            } else {
                $this->exists = false;
                $this->fill($data);
            }
            // if (static::find($data[$this->primaryKey])) $this->exists = true;
            // else $this->fill($data);
        }
    }

    /**
     * Check if model exists in database.
     * 
     * @return bool
     */
    public function isExists()
    {
        return $this->exists;
    }

    /**
     * Fill model with data.
     * 
     * @param array $data
     */
    public function fill(array $data)
    {
        if ($this->primaryKey) $this->oldPrimaryKeyValue = $data[$this->primaryKey] ?? null;

        foreach ($data as $key => $value) {
            $this->$key = $value;
            $this->columns[] = $key;
        }
    }

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
        return DB::table((new static)->getTableName())->setModel(get_called_class())->all();
    }

    /**
     * Get data from database table by primary key.
     * 
     * @param string $key
     * @return Model
     */
    public static function find($key)
    {
        // return DB::table((new static)->getTableName())->->where([(new static)->primaryKey => $key])->get(true);
        return DB::table((new static)->getTableName())->setModel(get_called_class())->where([(new static)->primaryKey => $key])->setModel(get_called_class())->first();
    }

    /**
     * Get data from database table by where clause.
     * 
     * @param array $where
     * @return array
     */
    public static function where(array $where)
    {
        return DB::table((new static)->getTableName())->select()->setModel(get_called_class())->where($where);
    }

    /**
     * Insert data to database table.
     * 
     * @param array $data
     * @return bool
     */
    public static function insert(array $data)
    {
        $model = new static;
        if ($model->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        return DB::table($model->getTableName())->setModel(get_called_class())->insert($data);
        // return DB::table((new static)->getTableName())->setModel(get_called_class())->insert($data);
    }

    /**
     * Update data from database table.
     * 
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        if (!$this->exists) return false;

        if ($this->timestamps) $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->primaryKey) $data[$this->primaryKey] = $this->oldPrimaryKeyValue;

        $result = DB::table((new static)->getTableName())->where(
            [$this->primaryKey => $this->oldPrimaryKeyValue]
        )->update($data);

        $this->oldPrimaryKeyValue = $data[$this->primaryKey] ?? $this->oldPrimaryKeyValue;

        return $result;
    }

    /**
     * Delete data from database table.
     * 
     * @return bool
     */
    public function delete()
    {
        if (!$this->exists) return false;

        return DB::table((new static)->getTableName())->where(
            [$this->primaryKey => $this->oldPrimaryKeyValue]
        )->delete();
    }

    public function save()
    {
        if ($this->exists) {
            $data = [];
            foreach ($this->columns as $column) {
                $data[$column] = $this->$column;
            }
            return $this->update($data);
        } else {
            return $this->insert($this->columns);
        }
    }

    // /**
    //  * Update data from database table.
    //  * 
    //  * @param array $data
    //  * @param array $where
    //  * @return bool
    //  */
    // public static function update(array $data, array $where)
    // {
    //     return DB::table((new static)->getTableName())->where($where)->update($data);
    // }

    // /**
    //  * Delete data from database table.
    //  * 
    //  * @param array $where
    //  * @return bool
    //  */
    // public static function delete(array $where)
    // {
    //     return DB::table((new static)->getTableName())->where($where)->delete();
    // }

    /**
     * Get model data as array.
     * 
     * @return array
     */
    public function toArray()
    {
        $data = [];
        foreach ($this->columns as $column) {
            $data[$column] = $this->$column;
        }
        return $data;
    }

    /**
     * Get model data as json.
     * 
     * @return string
     */
    public function toJson(): string
    {
        return (string) json($this->toArray());
    }


    /**
     * Get model data as json.
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * Get attribute value.
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) return $this->$name();

        return $this->$name ?? null;
    }

    /**
     * Set attribute value.
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
        $this->columns[] = $name;
    }

    /**
     * Check if attribute exists.
     * 
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->$name);
    }

    /**
     * Unset attribute.
     * 
     * @param string $name
     */
    public function __unset($name)
    {
        unset($this->$name);
    }
}
