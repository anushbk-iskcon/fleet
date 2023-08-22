<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRequisition extends Model
{
   
    protected $table = 'vehicle_requisition';
    protected $primaryKey = 'VEHICLE_REQ_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';
    protected $guarded = [];
}
