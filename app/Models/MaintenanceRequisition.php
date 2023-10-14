<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequisition extends Model
{
    use HasFactory;

    protected $table = 'maintenance_requisitions';
    protected $primaryKey = 'MAINTENANCE_REQ_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Alowing assignment
    protected $fillable = [
        'REQUISITION_TYPE',
        'REQUISITION_FOR',
        'EMPLOYEE_NAME',
        'VEHICLE_ID',
        'MAINTENANCE_TYPE',
        'MAINTENANCE_SERVICE_NAME',
        'SERVICE_DATE',
        'CHARGE',
        'TOTAL_AMOUNT',
        'PRIORITY',
        'INVOICE_FILE',
        'REMARKS',
        'APPROVAL_STATUS',
        'APPROVED_BY',
        'APPROVED_ON',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
