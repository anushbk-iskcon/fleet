<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceService extends Model
{
    use HasFactory;

    protected $table = 'maintenance_services';
    protected $primaryKey = 'MAINTENANCE_SERVICE_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'MAINTENANCE_SERVICE_NAME',
        'SERVICE_TYPE',
        'TRACK_BY_DATE',
        'FUEL_TRACKING',
        'MILAGE_TRACKING',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
