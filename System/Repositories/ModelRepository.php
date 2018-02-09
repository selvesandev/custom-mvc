<?php

namespace Application\System\Repositories;

interface ModelRepository
{
    public function getAll();

    public function getSingle();

    public function countAll();

    public function countSingle();

    public function insert(array $data);

    public function update(array $data);

    public function delete($primaryKeyValue);
}