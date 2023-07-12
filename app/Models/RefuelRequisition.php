<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefuelRequisition extends Model
{
    use HasFactory;

    protected $table = 'refueling_requisition';
    protected $primaryKey = 'REFUEL_REQUISITION_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'VEHICLE_ID',
        'FUEL_TYPE',
        'QUANTITY',
        'CURRENT_ODOMETER',
        'FUEL_STATION',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
