<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefuelSetting extends Model
{
    use HasFactory;

    protected $table = 'refuel_setting';
    protected $primaryKey = 'REFUEL_SETTING_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'VEHICLE',
        'DRIVER',
        'FUEL_TYPE',
        'REFUELED_DATE',
        'FUEL_STATION',
        'PLACE',
        'LAST_READING',
        'ODOMETER_AT_REFUEL',
        'UNIT_TAKEN',
        'FUEL_SLIP_SCAN_COPY',
        'SECURITY_NAME',
        'AMOUNT_PER_UNIT',
        'TOTAL_AMOUNT',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
