<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequisition extends Model
{
    use HasFactory;

    protected $table = '';
    protected $primaryKey = '';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Alowing assignment
    protected $fillable = [];
}
