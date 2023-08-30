<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    use HasFactory;

    protected $table = 'legal_documents';
    protected $primaryKey = 'LEGAL_DOCUMENT_ID';

    // Timestamps
    const CREATED_AT = 'CREATED_ON';
    const UPDATED_AT = 'MODIFIED_ON';

    // Allowing assignment
    protected $fillable = [
        'DOCUMENT_TYPE',
        'COMMISSION',
        'VEHICLE',
        'VENDOR',
        'LAST_ISSUE_DATE',
        'EXPIRE_DATE',
        'CHARGE_PAID',
        'NOTIFICATION_BEFORE',
        'EMAIL_NOTIFICATIONS',
        'SMS_NOTIFICATIONS',
        'EMAIL',
        'MOBILE',
        'DOCUMENT_ATTACHMENT',
        'IS_ACTIVE',
        'CREATED_BY',
        'CREATED_ON',
        'MODIFIED_BY',
        'MODIFIED_ON'
    ];
}
