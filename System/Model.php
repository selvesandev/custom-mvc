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

    public function getAll()
    {
        return $this->_connection->select($this->tableName, $this->fillable);
    }


    public function getSingle()
    {
    }

    public function countAll()
    {
    }

    public function countSingle()
    {

    }

    public function insert(array $data)
    {
        $data = $this->addTimeStamps($data);
        return $this->_connection->insert($this->tableName, $data);
    }

    public function update(array $data)
    {
    }

    public function delete($primaryKeyValue)
    {
        return $this->_connection->where([$this->primaryKey => $primaryKeyValue])->delete($this->tableName);
    }
}