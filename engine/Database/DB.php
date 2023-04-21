<?php

namespace Engine\Database;

class DB
{
    public static $db;
    protected $table;
    protected $method;

    /* SELECT METHOD */
    protected $select = [];
    protected $where = [];
    protected $limit = 0;
    protected $offset = 0;
    protected $orderBy = [];
    protected $groupBy = [];

    /* INSERT METHOD */
    protected $insert = [];

    /* UPDATE METHOD */
    protected $update = [];

    protected $query;
    protected $result;
    protected $data = [];

    /**
     * Constructor
     * 
     * @param string $table
     * @return void
     */
    public function __construct(string $table = '')
    {
        // get the .env file
        // $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        // $dotenv->load();

        // // connect to database
        // $this->db = new mysqli(
        //     $_ENV['DB_HOST'],
        //     $_ENV['DB_USER'],
        //     $_ENV['DB_PASS'],
        //     $_ENV['DB_NAME']
        // );

        $this->table = $table;
    }

    // public function __destruct()
    // {
    //     $this->db->close();
    // }

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
     * @return bool
     */
    protected function execute()
    {
        $this->result = $this->db->query($this->query);

        if ($this->db->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get($getOne = false)
    {
        // if (!$this->execute()) {
        //     return false;
        // }

        // $result = $this->result;

        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         $this->data[] = $row;
        //     }
        // }

        // return $getOne ? $this->data : $this->data[0];

        $this->setQuery();
        return $this->query;
    }

    public function find($id)
    {
        $this->query = "SELECT * FROM {$this->table} WHERE id = {$id}";
        return $this->get();
    }

    public function all()
    {
        $this->query = "SELECT * FROM {$this->table}";
        // return $this->get();
        return $this->query;
    }

    public function select($select = [])
    {
        $this->method = 'select';
        $this->select = $select;
        return $this;
    }

    /**
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
     * @return $this
     */
    public function first()
    {
        $this->method = 'select';
        $this->limit = 1;
        return $this->get(true);
    }

    /**
     * @return $this
     */
    public function latest()
    {
        $this->method = 'select';
        $this->orderBy = ['id' => 'desc'];
        return $this;
    }

    public function oldest()
    {
        $this->method = 'select';
        $this->orderBy = ['id' => 'asc'];
        return $this;
    }

    /**
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
        return $this->query;
    }

    /**
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
        return $this->query;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->method = 'delete';
        // return $this;

        $this->setQuery();
        return $this->query;
    }
}
