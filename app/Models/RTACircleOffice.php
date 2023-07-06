<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTACircleOffice extends Model
{
    use HasFactory;

    protected $table = 'mstr_rta_circle_office';
    protected $primaryKey = 'RTA_CIRCLE_OFFICE_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing mass assignment
    protected $fillable = [
        'RTA_CIRCLE_OFFICE_NAME',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
