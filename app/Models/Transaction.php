<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'other_transaction';
    protected $primaryKey = 'TRANSACTION_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing mass assignment
    protected $fillable = [
        'TRANSACTION_TYPE',
        'BILL_DATE',
        'DEVOTEE_NAME',
        'BILL_AMOUNT',
        'DEBIT_TO_DEPT',
        'DEPARTMENT_NAME',
        'INVOICE_DOCUMENT',
        'BILL_NUMBER',
        'DRIVER_ID',
        'VEHICLE_ID',
        'VEHICLE_TYPE_ID',
        'DESCRIPTION',
        'JOURNEY_START_DATE',
        'JOURNEY_RETURN_DATE',
        'JOURNEY_NUM_OF_DAYS',
        'RATE_PER_DAY',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
