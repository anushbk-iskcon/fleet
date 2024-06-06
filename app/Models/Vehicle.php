<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $primaryKey = 'VEHICLE_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'VEHICLE_NAME',
        'VEHICLE_TYPE_ID',
        'DEPARTMENT_ID',
        'DEPARTMENT_NAME',
        'VEHICLE_DIVISION_ID',
        'REGISTRATION_DATE',
        'RTA_CIRCLE_OFFICE_ID',
        'LICENSE_PLATE',
        'DRIVER_ID',
        'EMPLOYEE_ID',
        'EMPLOYEE_NAME',
        'ALERT_CELL_NUMBER',
        'VENDOR_ID',
        'ALERT_EMAIL_ID',
        'SEAT_CAPACITY',
        'OWNERSHIP_ID',
        'OWNERSHIP_NAME',
        'CHASSIS_NUMBER',
        'ENGINE_NUMBER',
        'VEHICLE_VALUE',
        'UVW',
        'CC',
        'RATE_PER_KM',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
