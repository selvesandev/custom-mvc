<?php

namespace Application\System;

use Application\System\Repositories\ModelRepository;

class Model implements ModelRepository
{
    protected $tableName = '';
    protected $fillable = [];

    private $_connection;

    public function __construct()
    {
        $this->_connection = Database::instantiate();
    }

    public function getAll()
    {
        echo $this->tableName;
        echo "<pre>";
        print_r($this->fillable);
        echo "</pre>";
        die;
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
        return $this->_connection->insert($this->tableName, $data);
    }

    public function update(array $data)
    {
    }

    public function delete()
    {
    }
}