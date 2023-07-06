<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\TripType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripTypeController extends Controller
{
    //
    /** 
     *  Return screen listing all currently available trip types
     */
    public function index()
    {
        $tripTypes = TripType::all();
        return view('system-settings.trip-types', compact('tripTypes'));
    }

    /**
     * Add new Trip Type to DB Table
     */
    public function store(Request $request)
    {
        $tripType = new TripType;
        $tripType->TRIP_NAME = $request->trip_type_name;
        $tripType->CREATED_BY = Auth::user()->USER_ID;
        $added = $tripType->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $tripType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add trip type']);
        }
    }

    /**
     * Update Trip Type Name in DB
     */
    public function update(Request $request)
    {
        $tripTypeId = $request->trip_type_id;
        $tripType = TripType::find($tripTypeId);
        $tripType->TRIP_NAME = $request->trip_type_name;
        $tripType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $tripType->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $tripType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update trip type']);
        }
    }

    /**
     * Activate/de-activate Trip Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $tripTypeId = $request->trip_type_id;
        $tripType = TripType::find($tripTypeId);

        if ($tripType->IS_ACTIVE == 'Y')
            $tripType->IS_ACTIVE = 'N';
        else
            $tripType->IS_ACTIVE = 'Y';

        $tripType->MODIFIED_BY = Auth::user()->USER_ID;
        $tripType->save();

        return response($tripType, 200);
    }
}
