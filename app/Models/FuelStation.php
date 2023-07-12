<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelStation extends Model
{
    use HasFactory;

    protected $table = 'mstr_fuel_station';
    protected $primaryKey = 'FUEL_STATION_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Alowing assignment
    protected $fillable = [
        'VENDOR_NAME',
        'FUEL_STATION_NAME',
        'STATION_CODE',
        'AUTHORIZE_PERSON',
        'CONTACT_NUMBER',
        'IS_AUTHORIZED',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
