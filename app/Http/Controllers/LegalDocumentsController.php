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

use function PHPUnit\Framework\returnSelf;

class LegalDocumentsController extends Controller
{
    //
    /**
     * Return page listing all legal documents
     */
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
            $vehicle = $request->vehiclesr;
            $doctype = $request->document_typesr;
            $expire_date_from = $request->exp_date_fr;
            $expire_date_to = $request->exp_date_to;

            $legalDocsList = DB::table('legal_documents')
                ->join('mstr_document_type', 'legal_documents.DOCUMENT_TYPE', '=', 'mstr_document_type.DOCUMENT_TYPE_ID')
                ->join('vehicles', 'legal_documents.VEHICLE', '=', 'vehicles.VEHICLE_ID')
                ->join('mstr_vendor', 'legal_documents.VENDOR', '=', 'mstr_vendor.VENDOR_ID')
                ->join('mstr_notification_type', 'legal_documents.NOTIFICATION_BEFORE', '=', 'mstr_notification_type.NOTIFICATION_TYPE_ID')
                ->select('legal_documents.*', 'mstr_document_type.DOCUMENT_TYPE_NAME', 'vehicles.VEHICLE_NAME', 'mstr_vendor.VENDOR_NAME', 'mstr_notification_type.NOTIFICATION_TYPE_NAME')
                ->when($vehicle, function ($query, $vehicle) {
                    return $query->where('legal_documents.VEHICLE', '=', $vehicle);
                })
                ->when($doctype, function ($query, $doctype) {
                    return $query->where('legal_documents.DOCUMENT_TYPE', '=', $doctype);
                })
                ->when($expire_date_from, function ($query, $expire_date_from) {
                    return $query->where('legal_documents.EXPIRE_DATE', '>=', $expire_date_from);
                })
                ->when($expire_date_to, function ($query, $expire_date_to) {
                    return $query->where('legal_documents.EXPIRE_DATE', '<=', $expire_date_to);
                })
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
        if (($request->is_email == 'on') && ($request->has('email')))
            $legalDocument->EMAIL = $request->email;
        if (($request->is_sms == 'on') && ($request->has('sms')))
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
        $legal_document_id = $request->legal_document_id;
        $legalDocument = LegalDocument::find($legal_document_id);

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
        if (($request->is_email == 'on') && ($request->has('email')))
            $legalDocument->EMAIL = $request->email;
        // else
        if (($request->is_sms == 'on') && ($request->has('sms')))
            $legalDocument->MOBILE = $request->sms;
        // else
        // Upload document if new one provided while submitting form
        if ($request->hasFile('document_attachment')) {
            $file = $request->file('document_attachment');
            $fileName = time() . '-' . date('Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/legal/');
            $file->move($uploadDestination, $fileName);
            $legalDocument->DOCUMENT_ATTACHMENT = $fileName;
        }

        $legalDocument->MODIFIED_BY = Auth::id();
        $updated = $legalDocument->save();

        if ($updated)
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
    }

    /**
     * Change Activation Status of Document
     */
    public function changeActivationStatus(Request $request)
    {
        $legal_document_id = $request->legal_document_id;
        $activation_status = $request->active_status == 1 ? 'Y' : 'N';

        $legalDocument = LegalDocument::find($legal_document_id);
        $legalDocument->IS_ACTIVE = $activation_status;
        $legalDocument->MODIFIED_BY = Auth::id();

        $statusChanged = $legalDocument->save();
        if ($statusChanged)
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
    }
}
