<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $table = 'vehicle_insurance';
    protected $primaryKey = 'INSURANCE_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'COMPANY_NAME',
        'VEHICLE',
        'POLICY_NUMBER',
        'CHARGE_PAYABLE',
        'START_DATE',
        'END_DATE',
        'RECURRING_PERIOD',
        'RECURRING_DATE',
        'RECURRING_PERIOD_REMINDER',
        'STATUS',
        'DEDUCTIBLE',
        'POLICY_DOCUMENT',
        'REMARKS',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
