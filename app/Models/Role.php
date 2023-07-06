<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'ROLE_ID';
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    protected $fillable = ['ROLE_NAME', 'DESCRIPTION', 'IS_ACTIVE', 'CREATED_BY', 'MODIFIED_BY'];
}
