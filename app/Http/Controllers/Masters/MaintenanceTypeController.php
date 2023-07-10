<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceTypeController extends Controller
{
    //
    /**
     * Listing of all current Maintenance Types
     */
    public function index()
    {
        $maintenanceTypes = MaintenanceType::all();
        return view('system-settings.maintenance-types', compact('maintenanceTypes'));
    }

    /**
     * Add new Maintenance Type to DB
     */
    public function store(Request $request)
    {
        $maintenanceType = new MaintenanceType;
        $maintenanceType->MAINTENANCE_NAME = $request->mainten_name;
        $maintenanceType->CREATED_BY = Auth::user()->USER_ID;
        $added = $maintenanceType->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully', 'data' => $maintenanceType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add new maintenance type']);
        }
    }

    /**
     * Update Maintenance Type Name in DB
     */
    public function update(Request $request)
    {
        $maintenance_id = $request->mainten_id;
        $maintenanceType = MaintenanceType::find($maintenance_id);
        $maintenanceType->MAINTENANCE_NAME = $request->mainten_name;
        $maintenanceType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $maintenanceType->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully', 'data' => $maintenanceType]);
        } else {
            return response()->json(['successCode' => 1, 'message' => 'Could not update maintenance type']);
        }
    }

    /**
     * Activate/de-activate Maintenance Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $maintenance_id = $request->mainten_id;
        $maintenanceType = MaintenanceType::find($maintenance_id);

        if ($maintenanceType->IS_ACTIVE == 'Y')
            $maintenanceType->IS_ACTIVE = 'N';
        else
            $maintenanceType->IS_ACTIVE = 'Y';

        $maintenanceType->save();
        return response($maintenanceType, 200);
    }
}
