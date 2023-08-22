<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rolepermissions extends Model
{
   
    protected $table = 'role_permissions';
    protected $primaryKey = 'USER_PERMISSION_ID';
    public $timestamps = false;
    protected $guarded = [];
}
