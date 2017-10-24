<?php

namespace litemerafrukt\Database;

use Anax\Common\ConfigureInterface;
use Anax\Common\ConfigureTrait;
use Illuminate\Support\Collection;

/**
 * Raw database connection and querier
 */
class Database implements ConfigureInterface
{
    use ConfigureTrait;

    private $pdo;

    /**
     * Connect to db
     */
    public function connect()
    {
        try {
            $this->pdo = new \PDO(...$this->config);
        } catch (\Exception $e) {
            // Rethrow to hide connection details, through the original
            // exception to view all connection details.
            // throw $e;
            throw new \PDOException("Could not connect to database.");
        }

        return $this;
    }

    /**
     * Get the \PDO object
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * Execute query and return a laravel collection
     *
     * @param string
     * @param array
     *
     * @return Collection
     */
    public function query2collection($sql, $params = [])
    {
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params);
        } catch (PDOException $exception) {
            throw new \PDOException("Error in database query2collection execution.");
        }

        // return (collect($statement->fetchAll(\PDO::FETCH_OBJ)));

        return collect($statement);
    }

    /**
     * Execute query and return the PDOStatement
     *
     * @param string
     * @param array
     *
     * @return \PDOStatement
     */
    public function query($sql, $params = [])
    {
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params);
        } catch (PDOException $exception) {
            throw new \PDOException("Error in database query execution.");
        }

        return $statement;
    }
}
