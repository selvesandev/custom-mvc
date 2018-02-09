<?php

namespace Application\System;

class Database
{
    //Connection
    private $_connection;
    private static $_instance = null;


    private $_criteria = '';
    private $_criteria_value = [];
    private $_order_by = '';
    private $_limit = '';


    private function __construct()
    {
        $this->connect();
    }

    /**
     * Connect with PDO
     */
    private function connect()
    {
        try {
            $this->_connection = new \PDO('mysql:host=127.0.0.1;dbname=php7', 'root', 'secret');
            $this->_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }


    /**
     * Single Pattern to connect to the database
     * @return Database|null
     */
    public static function instantiate()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }


    private function mandatoryArgCheck(string $tableName, array $data)
    {
        if (empty($tableName) || empty($data)) throw new \Exception("Table Name and Data are mandatory");
    }


    /**
     *
     * @param string $tableName
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function insert(string $tableName, array $data)
    {
        $this->mandatoryArgCheck($tableName, $data);
        $columns = array_keys($data);
        $columns = implode(',', $columns);

        $query = "INSERT INTO " . $tableName . '(' . $columns . ') VALUES ( ?';
        for ($i = 1; $i < count($data); $i++) {
            $query .= ',?';
        }
        $query .= ')';

        try {
            $stmt = $this->_connection->prepare($query);
            $stmt->execute(array_values($data));
            return $this->_connection->lastInsertId();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }


    /**
     * Add Criteria To the query
     * @param array $criteria
     * @return $this
     * @throws Exception
     */
    public function where(array $criteria)
    {
        if (empty($criteria)) throw new Exception('Pass array values to criteria');

        $columns = array_keys($criteria);

        $columns = implode('=? AND ', $columns);
        $columns .= '=?';

        $this->_criteria = $columns;
        $this->_criteria_value = array_values($criteria);
        return $this;
    }


    /**
     * Update Database
     * @param string $tableName
     * @param array $data
     * @return bool
     */
    public function update(string $tableName, array $data)
    {
        $this->mandatoryArgCheck($tableName, $data);

        $columns = array_keys($data);
        $columns = implode('=?,', $columns);
        $columns .= '=?';

        $query = "UPDATE " . $tableName . " SET " . $columns;

        if (!empty($this->_criteria)) {
            $query .= ' WHERE ' . $this->_criteria;
        }

        $execData = array_merge(array_values($data), $this->_criteria_value);
        $this->flushCriteria();
        try {
            $stmt = $this->_connection->prepare($query);
            $stmt->execute($execData);
            return true;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }


    public function count()
    {
        //Homework
    }


    /**
     * Flush Property being used in the query after use.
     */
    private function flushCriteria()
    {
        $this->_criteria_value = [];
        $this->_criteria = '';
        $this->_order_by = '';
        $this->_limit = '';
    }


    /**
     * Add Order By to select query to arrange the data asc or desc //rand()
     * @param string $column
     * @param string $type
     * @return $this
     * @throws Exception
     */
    public function orderBy(string $column, $type = 'asc')
    {
        $debug = debug_backtrace();
        $lineNumber = $debug[0]['line'];

        $type = strtolower($type);
        if (empty($column)) throw new Exception('Columns are mandatory when ordering data at line no ' . $lineNumber);

        if (!in_array($type, ['asc', 'desc'])) {
            throw new \Exception('Order can be only Asc or Desc');
        }


        $this->_order_by = ' ORDER BY ' . $column . ' ' . $type;
        return $this;
    }


    /**
     * To Set the limit in query when fetching dat
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function limit(int $limit, int $offset = 0)
    {
        $this->_limit = ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this;
    }


    /**
     * To Select Data select query.
     * @param string $tableName
     * @param array $columns
     * @return mixed
     */
    public function select(string $tableName, array $columns = [])
    {

        if (empty($columns)) $columns = '*';
        else
            $columns = implode(',', $columns);


        $query = "SELECT " . $columns . " FROM " . $tableName;
        if (!empty($this->_criteria_value)) {
            $query .= ' WHERE ' . $this->_criteria;
        }

        $execData = $this->_criteria_value;

        if (!empty($this->_order_by)) {
            $query .= ' ' . $this->_order_by;
        }

        if (!empty($this->_limit)) {
            $query .= $this->_limit;
        }

        $this->flushCriteria();

        try {
            $stmt = $this->_connection->prepare($query);
            $stmt->execute($execData);
            return $stmt->fetchAll(\PDO::FETCH_CLASS);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

        //select column,* from tablename [where column=? orderby name limit 2 offset 3]
    }


    /**
     * @param string $tableName
     * @return bool
     * @throws Exception
     */
    public function delete(string $tableName): bool
    {
        if (empty($tableName)) throw new Exception('Table name cannot be empty');

        $query = "DELETE FROM " . $tableName . ' ';
        if (!empty($this->_criteria)) {
            $query .= ' WHERE ' . $this->_criteria;
        }

        $execData = $this->_criteria_value;
        $this->flushCriteria();
        try {
            $stmt = $this->_connection->prepare($query);
            $stmt->execute($execData);
            return true;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

}
