<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    // protected $table = 'mstr_drivers';
    protected $primaryKey = 'DRIVER_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowng assignment
    protected $fillable = [
        'DRIVER_NAME', 'MOBILE_NUMBER', 'LICENSE_NUMBER', 'LICENSE_TYPE',
        'LICENSE_ISSUE_DATE', 'WORKING_TIME_START', 'WORKING_TIME_END',
        'JOIN_DATE', 'DATE_OF_BIRTH', 'PERMANENT_ADDRESS', 'PRESENT_ADDRESS', 'DISTANCE_FROM_TEMPLE', 'MODE_OF_TRAVEL',
        'LEAVE_STATUS', 'IS_ACTIVE', 'PROFILE_PHOTO', 'CTC', 'OVT',
        'EMERGENCY_CONTACT_NAME', 'EMERGENCY_CONTACT_NUMBER', 'EMERGENCY_CONTACT_REL',
        'CREATED_BY', 'CREATED_ON', 'MODIFIED_BY', 'MODIFIED_ON'
    ];
}
