<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelRateLog extends Model
{
    use HasFactory;

    protected $table = 'fuel_rate_log';
    protected $primaryKey = 'FUEL_RATE_LOG_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing mass assignment
    protected $fillable = [
        'FROM_DATE',
        'TO_DATE',
        'FUEL_TYPE',
        'FUEL_RATE',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
