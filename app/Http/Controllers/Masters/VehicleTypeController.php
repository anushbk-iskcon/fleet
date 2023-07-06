<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleTypeController extends Controller
{
    // Screen listing all current vehicle types
    public function index()
    {
        $vehicleTypes = VehicleType::all();
        return view('system-settings.vehicle-types', compact('vehicleTypes'));
    }

    // Add new vehcile type to database
    public function store(Request $request)
    {
        $vehicleType = new VehicleType;
        $vehicleType->VEHICLE_TYPE_NAME = $request->vehicletype_name;
        $vehicleType->IS_ACTIVE = 'Y';
        $vehicleType->CREATED_BY = Auth::user()->USER_ID;
        $created = $vehicleType->save();

        if ($created) {
            return response()->json(['successCode' => 1, 'message' => "Successfully added new vehicle type", 'vehicleType' => $vehicleType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => "Failed to add new vehicle type"]);
        }
    }

    // Update vehicle type name
    public function update(Request $request)
    {
        $vehicle_type_id = $request->vehicle_type_id;
        $vehicleType = VehicleType::find($vehicle_type_id);
        $vehicleType->VEHICLE_TYPE_NAME = $request->new_vehicletype_name;
        $vehicleType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $vehicleType->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => "Successfully updated vehicle type", 'vehicleType' => $vehicleType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => "Failed to update vehicle type"]);
        }
    }

    // Activate / De-activate Vehcile Type
    public function statusUpdate(Request $request)
    {
        $vehicle_type_id = $request->vehicle_type_id;
        $vehicleType = VehicleType::find($vehicle_type_id);
        if ($vehicleType->IS_ACTIVE == 'Y') {
            $vehicleType->IS_ACTIVE = 'N';
        } else {
            $vehicleType->IS_ACTIVE = 'Y';
        }
        $vehicleType->MODIFIED_BY = Auth::user()->USER_ID;
        $vehicleType->save();

        return response($vehicleType, 200);
    }
}
