<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\VehicleDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleDivisionController extends Controller
{
    // Screen to show all current vehicle divisions
    public function index()
    {
        $vehicleDivisions = VehicleDivision::all();
        return view('system-settings.divisions', compact('vehicleDivisions'));
    }

    // Store newly created vehicle division in DB
    public function store(Request $request)
    {
        $vehicleDivision = new VehicleDivision;
        $vehicleDivision->VEHICLE_DIVISION_NAME = $request->division_name;
        $vehicleDivision->IS_ACTIVE = 'Y';
        $vehicleDivision->CREATED_BY = Auth::user()->USER_ID;
        $created = $vehicleDivision->save();

        if ($created) {
            return response()->json(['successCode' => 1, 'message' => "Successfully added new division", 'data' => $vehicleDivision]);
        } else {
            return response()->json(['successCode' => 0, 'message' => "Failed to add new division"]);
        }
    }

    // Update vehicle division name
    public function update(Request $request)
    {
        $division_id = $request->division_id;
        $division = VehicleDivision::find($division_id);
        $division->VEHICLE_DIVISION_NAME = $request->new_division_name;
        $division->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $division->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => "Successfully updated division", 'data' => $division]);
        } else {
            return response()->json(['successCode' => 0, 'message' => "Failed to update division"]);
        }
    }

    // Activate / De-activate Vehcile Division
    public function statusUpdate(Request $request)
    {
        $division_id = $request->division_id;
        $division = VehicleDivision::find($division_id);
        if ($division->IS_ACTIVE == 'Y') {
            $division->IS_ACTIVE = 'N';
        } else {
            $division->IS_ACTIVE = 'Y';
        }
        $division->MODIFIED_BY = Auth::user()->USER_ID;
        $division->save();

        return response($division, 200);
    }
}
