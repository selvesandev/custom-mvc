<?php

namespace Application\App\Models;

use Application\System\Model;

class Admin extends Model
{
    protected $tableName = 'admins';
    protected $fillable = ['name', 'email', 'password', 'image', 'status', 'created_at', 'updated_at'];

}