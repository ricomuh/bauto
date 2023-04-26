<?php

namespace Engine\Database;

use Engine\Helper\Collection;

class DatabaseResult
{
    /**
     * Database result.
     * 
     * @var \Mysqli_Result
     */
    private $result;

    /**
     * Database result constructor.
     * 
     * @param \Mysqli_Result $result
     */
    public function __construct(\Mysqli_Result $result)
    {
        $this->result = $result;
    }

    /**
     * Fetch all rows from database result.
     * 
     * @return array
     */
    public function fetchAll(): Collection
    {
        // return $this->result->fetch_all(MYSQLI_ASSOC);
        return collect($this->result->fetch_all(MYSQLI_ASSOC));
    }

    /**
     * Fetch single row from database result.
     * 
     * @return array
     */
    public function fetch(): array
    {
        return $this->result->fetch_assoc();
    }

    /**
     * Get number of rows from database result.
     * 
     * @return int
     */
    public function count(): int
    {
        return $this->result->num_rows;
    }
}
