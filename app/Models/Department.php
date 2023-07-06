<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'mstr_department';
    protected $primaryKey = 'DEPARTMENT_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowng assignment
    protected $fillable = [
         'DEPARTMENT_NAME',
         'IS_ACTIVE',
         'CREATED_BY', 
         'CREATED_ON', 
         'MODIFIED_BY', 
         'MODIFIED_ON'
    ];
}
