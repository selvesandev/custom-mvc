<?php

namespace Application\App\Models;

use Application\System\Model;

class Users extends Model
{
    public $tableName = 'users';
    public $fillable = ['name', 'email'];
}