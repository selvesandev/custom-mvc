<?php

namespace Application\System;

use Application\System\Repositories\ModelRepository;

class Model implements ModelRepository
{
    protected $tableName = '';
    protected $fillable = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';

    private $_connection;

    public function __construct()
    {
        $this->_connection = Database::instantiate();
    }

    private function addTimeStamps(array $data)
    {
        if ($this->timestamp) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }

    /**
     * Fetch all data attach criteria if necessary
     * @param array $criteria
     * @return mixed
     */
    public function getAll(array $criteria = [])
    {
        if (!empty($criteria))
            $this->_connection->where($criteria);

        return $this->_connection->select($this->tableName, $this->fillable);
    }


    public function getSingle(array $criteria = [])
    {
        $data = $this->getAll($criteria);
        if (!count($data)) return [];

        return $data[0];
    }


    public function find($id)
    {
        if (empty($id)) return false;
        $data = $this->_connection->where([$this->primaryKey => $id])->select($this->tableName, $this->fillable);

        if (!$data) return false;

        return $data[0];
    }


    public function countAll()
    {
    }

    public function countSingle()
    {

    }

    /**
     * Insert
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        $data = $this->addTimeStamps($data);
        return $this->_connection->insert($this->tableName, $data);
    }

    public function update(array $data, $id)
    {
        return $this->_connection->where([$this->primaryKey => $id])->update($this->tableName, $data);
    }

    /**
     * Delete
     * @param $primaryKeyValue
     * @return bool
     */
    public function delete($primaryKeyValue)
    {
        return $this->_connection->where([$this->primaryKey => $primaryKeyValue])->delete($this->tableName);
    }

}