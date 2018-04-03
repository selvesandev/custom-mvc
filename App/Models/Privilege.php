<?php

namespace Application\App\Models;

use Application\System\Model;

class Privilege extends Model
{
    public $tableName = 'privileges';
    public $fillable = ['type', 'id'];
}