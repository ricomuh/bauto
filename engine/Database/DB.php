<?php

namespace Engine\Database;

class DB
{
    /**
     * Database object.
     * 
     * @var \Engine\Database\Database
     */
    public $db;
    /**
     * Database table name.
     * 
     * @var string
     */
    protected $table;
    /**
     * Database query method.
     * 
     * @var string
     */
    protected $method;

    /* SELECT METHOD */

    /**
     * Database select column.
     * 
     * @var array
     */
    protected $select = [];

    /**
     * Database where clause.
     * 
     * @var array
     */
    protected $where = [];

    /**
     * Database limit.
     * 
     * @var int
     */
    protected $limit = 0;

    /**
     * Database offset.
     * 
     * @var int
     */
    protected $offset = 0;

    /**
     * Database order by.
     * 
     * @var array
     */
    protected $orderBy = [];

    /**
     * Database group by.
     * 
     * @var array
     */
    protected $groupBy = [];

    /* INSERT METHOD */

    /**
     * Database insert column.
     * 
     * @var array
     */
    protected $insert = [];

    /* UPDATE METHOD */

    /**
     * Database update column.
     * 
     * @var array
     */
    protected $update = [];

    /**
     * Database query.
     * 
     * @var string
     */
    protected $query;

    /**
     * Database result.
     * 
     * @var array
     */
    protected $result;

    /**
     * Database data.
     * 
     * @var array
     */
    protected $data = [];

    /**
     * Constructor
     * 
     * @param string $table
     * @return void
     */
    public function __construct(string $table = '')
    {
        $this->db = $GLOBALS['db'];

        $this->table = $table;
    }

    /**
     * merge array to string
     */
    protected function mergeArrayToString($array, $separator = ',')
    {
        if (array_keys($array) !== range(0, count($array) - 1)) {
            $string = '';
            foreach ($array as $key => $value) {
                $string .= "{$key} = {$value},";
            }
            return rtrim($string, ',');
        }

        return implode($separator, $array);
    }

    protected function getSelectString()
    {
        $select = '';
        if (count($this->select) > 0) {
            $select .= $this->mergeArrayToString($this->select);
        } else {
            $select .= "*";
        }

        return $select;
    }

    protected function getWhereString()
    {
        $where = '';
        foreach ($this->where as $key => $value) {
            if (is_array($value)) {
                $where .= implode(' ', $value) . ' AND ';
            } else {
                $where .= " {$key} = '{$value}' AND ";
            }
        }
        return rtrim($where, ' AND ');
    }

    protected function getOrderByString()
    {
        return $this->mergeArrayToString($this->orderBy, ',');
    }

    protected function getGroupByString()
    {
        return $this->mergeArrayToString($this->groupBy, ',');
    }

    protected function getUpdateString()
    {
        return $this->mergeArrayToString($this->update, ',');
    }

    protected function setQuery()
    {
        switch ($this->method) {
            case 'select':
                $this->query = "SELECT ";
                $this->query .= $this->getSelectString();
                $this->query .= " FROM {$this->table}";
                if (count($this->where) > 0) {
                    $this->query .= " WHERE ";
                    $this->query .= $this->getWhereString();
                }
                if (count($this->orderBy) > 0) {
                    $this->query .= " ORDER BY ";
                    $this->query .= $this->getOrderByString();
                }
                if (count($this->groupBy) > 0) {
                    $this->query .= " GROUP BY ";
                    $this->query .= $this->getGroupByString();
                }
                if ($this->limit > 0) {
                    $this->query .= " LIMIT {$this->limit}";
                }
                if ($this->offset > 0) {
                    $this->query .= " OFFSET {$this->offset}";
                }

                break;
            case 'insert':
                $this->query = "INSERT INTO {$this->table} (";
                $this->query .= $this->mergeArrayToString(array_keys($this->insert), ', ');
                $this->query .= ") VALUES ('";
                $this->query .= $this->mergeArrayToString(array_values($this->insert), "','");
                $this->query .= "')";

                break;
            case 'update':
                $this->query = "UPDATE {$this->table} SET";
                $this->query .= $this->getUpdateString();
                $this->query .= " WHERE ";
                $this->query .= $this->getWhereString();

                break;
            case 'delete':
                $this->query = "DELETE FROM {$this->table} WHERE ";
                $this->query .= $this->getWhereString();

                break;
        }
    }

    public static function table($table)
    {
        return new DB(table: $table);
    }

    /**
     * Execute query
     * 
     * @return Engine\Database\DatabaseResult
     */
    protected function execute()
    {
        $this->result = $this->db->query($this->query);

        return $this->result;
    }

    /**
     * Get data from database
     * 
     * @param bool $getOne
     * @return array
     */
    public function get($getOne = false)
    {
        $this->setQuery();
        if ($getOne) return $this->execute()->fetch();
        return $this->execute()->fetchAll();
    }

    /**
     * Find data by id
     * 
     * @param int $id
     * @return array
     */
    public function find($id)
    {
        $this->query = "SELECT * FROM {$this->table} WHERE id = {$id}";
        return $this->get(true);
    }

    /**
     * Get all data from table
     * 
     * @return array
     */
    public function all()
    {
        $this->query = "SELECT * FROM {$this->table}";

        return $this->execute()->fetchAll();
    }

    /**
     * Insert data to database
     * 
     * @param array $data
     * @return Engine\Database\DatabaseResult
     */
    public function select($select = [])
    {
        $this->method = 'select';
        $this->select = $select;
        return $this;
    }

    /**
     * Set the where clause
     * 
     * @param array $where
     * @return $this
     * 
     * Example:
     * $db->where([
     *    'nama' => 'John',
     *    'nim' => '123456'
     *    ['age', '>', '20']
     *    ['age', 'between', '20', '30']
     *    ['alamat', 'like', '%jalan%']] 
     * ]);
     */
    public function where($where = [])
    {
        $this->where = $where;
        return $this;
    }

    /**
     * Set the limit clause
     * 
     * @param array $orderBy
     * @return $this
     * 
     * Example:
     * $db->orderBy([
     *    'nama' => 'asc',
     *    'nim' => 'desc'
     * ]);
     */
    public function limit($limit = 0)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set the offset clause
     * 
     * @param array $orderBy
     * @return $this
     * 
     * Example:
     * $db->orderBy([
     *    'nama' => 'asc',
     *    'nim' => 'desc'
     * ]);
     */
    public function offset($offset = 0)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Set the group by clause
     * 
     * @return $this
     */
    public function first()
    {
        $this->method = 'select';
        $this->limit = 1;
        return $this->get(true);
    }

    /**
     * Set the group by clause
     * 
     * @return $this
     */
    public function latest()
    {
        $this->method = 'select';
        $this->orderBy = ['id' => 'desc'];
        return $this;
    }

    /**
     * Set the group by clause
     * 
     * @return $this
     */
    public function oldest()
    {
        $this->method = 'select';
        $this->orderBy = ['id' => 'asc'];
        return $this;
    }

    /**
     * Set the order by clause
     * 
     * @param array $orderBy
     * @return $this
     * 
     * Example:
     * $db->orderBy([
     *    'nama' => 'asc',
     *    'nim' => 'desc'
     * ]);
     */
    public function orderBy($orderBy = [])
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * Set the group by clause
     * 
     * @param array $groupBy
     * @return $this
     * 
     * Example:
     * $db->groupBy([
     *    'nama',
     *    'nim'
     * ]);
     */
    public function groupBy($groupBy = [])
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    /**
     * Insert data to database
     * 
     * @param array $insert
     * @return $this
     * 
     * Example:
     * $db->insert([
     *    'nama' => 'John',
     *    'nim' => '123456'
     * ]);
     */
    public function insert($insert = [])
    {
        $this->method = 'insert';
        $this->insert = $insert;
        // return $this;

        $this->setQuery();
        return $this->execute();
    }

    /**
     * Update data to database
     * 
     * @param array $update
     * @return $this
     * 
     * Example:
     * $db->update([
     *    'nama' => 'John',
     *    'nim' => '123456'
     * ]);
     */
    public function update($update = [])
    {
        $this->method = 'update';
        $this->update = $update;
        // return $this;

        $this->setQuery();
        return $this->execute();
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->method = 'delete';
        // return $this;

        $this->setQuery();
        return $this->execute();
    }
}
