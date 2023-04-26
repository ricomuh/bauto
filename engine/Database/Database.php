<?php

namespace Engine\Database;

class Database
{
    /**
     * Database host.
     * 
     * @var string
     */
    private $host;

    /**
     * Database name.
     * 
     * @var string
     */
    private $name;

    /**
     * Database username.
     * 
     * @var string
     */
    private $username;

    /**
     * Database password.
     * 
     * @var string
     */
    private $password;

    /**
     * Database mysql connection.
     * 
     * @var \Mysqli
     */
    private $connection;

    /**
     * Database constructor.
     * 
     * @param string $host
     * @param string $name
     * @param string $username
     * @param string $password
     */
    public function __construct(string $host, string $name, string $username, string $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    /**
     * Connect to the database.
     * 
     * @return void
     */
    public function connect()
    {
        $this->connection = new \Mysqli($this->host, $this->username, $this->password, $this->name);

        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }
    }

    /**
     * Disconnect from the database.
     * 
     * @return void
     */
    public function disconnect()
    {
        $this->connection->close();
    }

    /**
     * Get the database connection.
     * 
     * @return \Mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Query the database.
     * 
     * @param string $query
     * @return \Engine\Database\DatabaseResult
     */
    public function query(string $query)
    {
        $result = $this->connection->query($query);

        if ($result === false) {
            die('Query failed: ' . $this->connection->error);
        }

        return new DatabaseResult($result);
    }

    /**
     * Get the last inserted id.
     * 
     * @return int
     */
    public function lastInsertId()
    {
        return $this->connection->insert_id;
    }

    /**
     * Escape the given value.
     * 
     * @param string $value
     * @return string
     */
    public function escape(string $value)
    {
        return $this->connection->real_escape_string($value);
    }
}
