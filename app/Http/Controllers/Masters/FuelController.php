<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FuelController extends Controller
{
    /** 
     *  Return screen listing all currently available fuel types
     */
    public function index()
    {
        $fuelTypes = Fuel::all();
        return view('system-settings.fuel-types', compact('fuelTypes'));
    }

    /**
     * Add new Fuel Type to DB Table
     */
    public function store(Request $request)
    {
        $fuelType = new Fuel;
        $fuelType->FUEL_TYPE_NAME = $request->fuel_type_name;
        $fuelType->CREATED_BY = Auth::user()->USER_ID;
        $added = $fuelType->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $fuelType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add fuel type']);
        }
    }

    /**
     * Update Fuel Type Name in DB
     */
    public function update(Request $request)
    {
        $fuelTypeId = $request->fuel_type_id;
        $fuelType = Fuel::find($fuelTypeId);
        $fuelType->FUEL_TYPE_NAME = $request->fuel_type_name;
        $fuelType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $fuelType->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $fuelType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add fuel type']);
        }
    }

    /**
     * Activate/de-activate Fuel Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $fuelTypeId = $request->fuel_id;
        $fuelType = Fuel::find($fuelTypeId);

        if ($fuelType->IS_ACTIVE == 'Y')
            $fuelType->IS_ACTIVE = 'N';
        else
            $fuelType->IS_ACTIVE = 'Y';

        $fuelType->MODIFIED_BY = Auth::user()->USER_ID;
        $fuelType->save();

        return response($fuelType, 200);
    }
}
