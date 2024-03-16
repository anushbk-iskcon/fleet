<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleComplaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';
    protected $primaryKey = 'COMPLAINT_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'COMPLAINT_REGISTER',
        'VEHICLE_ID',
        'COMPLAINT_DATE',
        'JOB_CARD_NUMBER',
        'VEHICLE_TYPE_ID',
        'MODEL',
        'ODOMETER_READING',
        'DRIVER_ID',
        'REPAIR_DETAILS',
        'REPAIR_START_DATE',
        'REPAIR_COMPLETION_DATE',
        'BILL_AMOUNT',
        'APPROVAL_STATUS',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
