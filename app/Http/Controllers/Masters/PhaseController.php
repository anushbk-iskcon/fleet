<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Phase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhaseController extends Controller
{
    //
    /** 
     *  Return screen listing all currently available Requisition Phases
     */
    public function index()
    {
        $phases = Phase::all();
        return view('system-settings.requisition-phases', compact('phases'));
    }

    /**
     * Add new Requisition Phase to DB Table
     */
    public function store(Request $request)
    {
        $phase = new Phase;
        $phase->PHASE_NAME = $request->phase_name;
        $phase->CREATED_BY = Auth::user()->USER_ID;
        $added = $phase->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $phase]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add phase']);
        }
    }

    /**
     * Update Requisition Phase Name in DB
     */
    public function update(Request $request)
    {
        $phaseId = $request->phase_id;
        $phase = Phase::find($phaseId);
        $phase->PHASE_NAME = $request->phase_name;
        $phase->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $phase->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $phase]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update phase']);
        }
    }

    /**
     * Activate/de-activate Phase in DB
     */
    public function statusUpdate(Request $request)
    {
        $phaseId = $request->phase_id;
        $phase = Phase::find($phaseId);

        if ($phase->IS_ACTIVE == 'Y')
            $phase->IS_ACTIVE = 'N';
        else
            $phase->IS_ACTIVE = 'Y';

        $phase->MODIFIED_BY = Auth::user()->USER_ID;
        $phase->save();

        return response($phase, 200);
    }
}
