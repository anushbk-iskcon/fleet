<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalAuthority extends Model
{
    use HasFactory;

    protected $table = 'mstr_approval_authorities';
    protected $primaryKey = 'AUTHORITY_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'REQUISITION_TYPE',
        'REQUISITION_PHASE',
        'DEPARTMENT_CODE',
        'DEPARTMENT_NAME',
        'EMPLOYEE_ID',
        'EMPLOYEE_NAME',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
