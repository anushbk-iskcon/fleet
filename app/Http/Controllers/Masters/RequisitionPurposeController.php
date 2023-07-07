<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\RequisitionPurpose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitionPurposeController extends Controller
{
    //
    /** 
     *  Return screen listing all currently available Requisition Purposes
     */
    public function index()
    {
        $purposes = RequisitionPurpose::all();
        return view('system-settings.requisition-purposes', compact('purposes'));
    }

    /**
     * Add new Requisition Purpose to DB Table
     */
    public function store(Request $request)
    {
        $reqPurpose = new RequisitionPurpose;
        $reqPurpose->REQUISITION_PURPOSE_NAME = $request->req_purpose;
        $reqPurpose->CREATED_BY = Auth::user()->USER_ID;
        $added = $reqPurpose->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $reqPurpose]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add requisition purpose']);
        }
    }

    /**
     * Update Requisition Purpose Name in DB
     */
    public function update(Request $request)
    {
        $purposeId = $request->req_purpose_id;
        $reqPurpose = RequisitionPurpose::find($purposeId);
        $reqPurpose->REQUISITION_PURPOSE_NAME = $request->req_purpose;
        $reqPurpose->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $reqPurpose->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $reqPurpose]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update requisition purpose']);
        }
    }

    /**
     * Activate/de-activate Req. Purpose in DB
     */
    public function statusUpdate(Request $request)
    {
        $purposeId = $request->req_purpose_id;
        $reqPurpose = RequisitionPurpose::find($purposeId);

        if ($reqPurpose->IS_ACTIVE == 'Y')
            $reqPurpose->IS_ACTIVE = 'N';
        else
            $reqPurpose->IS_ACTIVE = 'Y';

        $reqPurpose->MODIFIED_BY = Auth::user()->USER_ID;
        $reqPurpose->save();

        return response($reqPurpose, 200);
    }
}
