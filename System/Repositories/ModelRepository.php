<?php

namespace Application\System\Repositories;

interface ModelRepository
{
    public function getAll(array $criteria = []);

    public function getSingle(array $criteria = []);

    public function countAll();

    public function countSingle();

    public function insert(array $data);

    public function update(array $data,$id);

    public function delete($primaryKeyValue);

    public function find($id);
}