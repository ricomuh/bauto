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
     * @param string $model
     * @return array
     */
    public function fetchAll(string $model): Collection
    {
        // return $this->result->fetch_all(MYSQLI_ASSOC);
        // return collect($this->result->fetch_all(MYSQLI_ASSOC));
        $result = collect($this->result->fetch_all(MYSQLI_ASSOC));
        // dd($result, $model);
        if (!$model) return $result;
        return $result->map(function ($item) use ($model) {
            return new $model(true, $item, true);
        });
    }

    /**
     * Fetch single row from database result.
     * 
     * 
     */
    public function fetch(string $model)
    {
        if ($this->result->num_rows > 0) {
            $result = $this->result->fetch_assoc();
            if (!$model) return $result;
            return new $model(true, $result, true);
        }
        return [];
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
