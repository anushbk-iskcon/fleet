<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\RequisitionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitionTypeController extends Controller
{
    //
    /** 
     *  Return screen listing all currently available Requisition Types
     */
    public function index()
    {
        $reqTypes = RequisitionType::all();
        return view('system-settings.requisition-types', compact('reqTypes'));
    }

    /**
     * Add new Requisition Type to DB Table
     */
    public function store(Request $request)
    {
        $reqType = new RequisitionType;
        $reqType->REQUISITION_TYPE_NAME = $request->req_type_name;
        $reqType->CREATED_BY = Auth::user()->USER_ID;
        $added = $reqType->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $reqType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add requisition type']);
        }
    }

    /**
     * Update Requisition Type Name in DB
     */
    public function update(Request $request)
    {
        $reqTypeId = $request->req_type_id;
        $reqType = RequisitionType::find($reqTypeId);
        $reqType->REQUISITION_TYPE_NAME = $request->req_type_name;
        $reqType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $reqType->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $reqType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update requisition type']);
        }
    }

    /**
     * Activate/de-activate Req. Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $reqTypeId = $request->req_type_id;
        $reqType = RequisitionType::find($reqTypeId);

        if ($reqType->IS_ACTIVE == 'Y')
            $reqType->IS_ACTIVE = 'N';
        else
            $reqType->IS_ACTIVE = 'Y';

        $reqType->MODIFIED_BY = Auth::user()->USER_ID;
        $reqType->save();

        return response($reqType, 200);
    }
}
