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
        'DRIVER_MOBILE',
        'REFUELED_DATE',
        'REFUEL_LIMIT_TYPE',
        'FUEL_STATION',
        'MAX_UNIT',
        'BUDGET_GIVEN',
        'PLACE',
        'KILOMETER_PER_UNIT',
        'LAST_READING',
        'LAST_UNIT',
        'CONSUMPTION_PERCENT',
        'ODOMETER_DAY_END',
        'ODOMETER_AT_REFUEL',
        'UNIT_TAKEN',
        'FUEL_SLIP_SCAN_COPY',
        'STRICT_CONSUMPTION',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
