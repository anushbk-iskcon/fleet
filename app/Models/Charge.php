<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $table = 'charges';
    protected $primaryKey = 'CHARGE_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing mass assignment
    protected $fillable = [
        'CHARGE_TYPE',
        'VEHICLE_ID',
        'VEHICLE_TYPE_ID',
        'CHALLAN_NUMBER',
        'START_DATE',
        'EXPIRE_DATE',
        'AMOUNT',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
