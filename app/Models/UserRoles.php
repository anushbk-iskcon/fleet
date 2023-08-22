<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
   
    protected $table = 'user_roles';
    protected $primaryKey = 'USER_ID';
    public $timestamps = false;
    protected $guarded = [];
}
