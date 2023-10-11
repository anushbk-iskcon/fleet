<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverInfoLog extends Model
{
    use HasFactory;

    protected $table = 'driver_info_log';
    protected $primaryKey = 'INFO_LOG_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Make assignable
    protected $fillable = [
        'DRIVER',
        'DATE',
        'CATEGORY',
        'REMARKS',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
