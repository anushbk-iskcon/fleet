<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverTransaction extends Model
{
    use HasFactory;

    protected $table = 'driver_transaction';
    protected $primaryKey = 'TRANSACTION_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'TRANSACTION_DATE',
        'PURPOSE',
        'DRIVER_ID',
        'DURATION',
        'AMOUNT',
        'DEVOTEE_NAME',
        'DEVOTEE_DEPARTMENT_CODE',
        'DEVOTEE_DEPARTMENT_NAME',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
