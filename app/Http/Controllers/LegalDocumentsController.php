<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\LegalDocument;
use App\Models\NotificationType;
use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LegalDocumentsController extends Controller
{
    //
    /**
     * Return page listing all legal documents
     */
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
            $legalDocsList = DB::table('legal_documents')
                ->join('mstr_document_type', 'legal_documents.DOCUMENT_TYPE', '=', 'mstr_document_type.DOCUMENT_TYPE_ID')
                ->join('vehicles', 'legal_documents.VEHICLE', '=', 'vehicles.VEHICLE_ID')
                ->join('mstr_vendor', 'legal_documents.VENDOR', '=', 'mstr_vendor.VENDOR_ID')
                ->join('mstr_notification_type', 'legal_documents.NOTIFICATION_BEFORE', '=', 'mstr_notification_type.NOTIFICATION_TYPE_ID')
                ->select('legal_documents.*', 'mstr_document_type.DOCUMENT_TYPE_NAME', 'vehicles.VEHICLE_NAME', 'mstr_vendor.VENDOR_NAME', 'mstr_notification_type.NOTIFICATION_TYPE_NAME')
                ->get();

            return $legalDocsList->toJson();
        } else {
            $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get(['VEHICLE_ID', 'VEHICLE_NAME']);
            $documentTypes = DocumentType::where('IS_ACTIVE', 'Y')->get(['DOCUMENT_TYPE_ID', 'DOCUMENT_TYPE_NAME']);
            $vendors = Vendor::where('IS_ACTIVE', 'Y')->get(['VENDOR_ID', 'VENDOR_NAME']);
            $notifTypes = NotificationType::where('IS_ACTIVE', 'Y')->get(['NOTIFICATION_TYPE_ID', 'NOTIFICATION_TYPE_NAME']);
            return view('vehicle.legal-docs', compact('vehicles', 'documentTypes', 'vendors', 'notifTypes'));
        }
    }

    /**
     * Add new Legal Document to Database
     */
    public function store(Request $request)
    {
        $legalDocument = new LegalDocument;
        $legalDocument->DOCUMENT_TYPE = $request->document_type;
        $legalDocument->VEHICLE = $request->vehicle;
        $legalDocument->VENDOR = $request->vendor;
        $legalDocument->LAST_ISSUE_DATE = $request->last_issue_date;
        $legalDocument->EXPIRE_DATE = $request->expire_date;
        $legalDocument->CHARGE_PAID = $request->charge_paid;
        $legalDocument->COMMISSION = $request->commission;
        $legalDocument->NOTIFICATION_BEFORE = $request->notification_before;
        $legalDocument->EMAIL_NOTIFICATIONS = ($request->is_email == 'on' ? 'Y' : 'N');
        $legalDocument->SMS_NOTIFICATIONS = ($request->is_sms == 'on' ? 'Y' : 'N');
        if ($request->has('email'))
            $legalDocument->EMAIL = $request->email;
        if ($request->has('sms'))
            $legalDocument->MOBILE = $request->sms;

        // Upload document if provided while submitting form
        if ($request->hasFile('document_attachment')) {
            $file = $request->file('document_attachment');
            $fileName = time() . '-' . date('Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/legal/');
            $file->move($uploadDestination, $fileName);
            $legalDocument->DOCUMENT_ATTACHMENT = $fileName;
        }

        $legalDocument->CREATED_BY = Auth::id();
        $added = $legalDocument->save();

        if ($added)
            return response()->json(['successCode' => 1, 'message' => 'Legal document added successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to add document']);
    }

    /**
     * Get details of specified legal document
     */
    public function getDetails(Request $request)
    {
        $legal_document_id = $request->legal_document_id;
        $legalDocument = LegalDocument::find($legal_document_id);
        return $legalDocument->toJSON();
    }

    /**
     * Update a specified legal document's details
     */
    public function update(Request $request)
    {
    }
}
