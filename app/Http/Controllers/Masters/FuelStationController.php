<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\FuelStation;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FuelStationController extends Controller
{
    //
    /**
     * Screen listing all Fuel Stations
     */
    public function index()
    {
        // $fuelStations = FuelStation::all();
        return view('refueling.fuel-stations');
    }

    /**
     * Return JSON response listing all / filtered fuel stations
     */
    public function list(Request $request)
    {
        $vendor = $request->vendorsr;
        $station = $request->station_namesr;
        // dd($station, $vendor);

        // Filtered data if request does not have empty values above
        $fuelStations = FuelStation::query()
            ->when($vendor, function ($query) use ($vendor) {
                $query->where('VENDOR_NAME', 'LIKE', '%' . $vendor . '%');
            })
            ->when($station, function ($query) use ($station) {
                $query->where('FUEL_STATION_NAME', 'LIKE', '%' . $station . '%');
            })->get();
        return json_encode($fuelStations);
    }

    /**
     * Add new Fuel Station to DB
     */
    public function store(Request $request)
    {
        $fuelStation = new FuelStation;
        $fuelStation->VENDOR_NAME = $request->vendor_name;
        $fuelStation->FUEL_STATION_NAME = $request->station_name;
        $fuelStation->STATION_CODE =  $request->station_code;
        $fuelStation->AUTHORIZE_PERSON = $request->authorize_person;
        $fuelStation->CONTACT_NUMBER = $request->contact_num;
        if (isset($request->is_authorized))
            $fuelStation->IS_AUTHORIZED = 'Y';
        else
            $fuelStation->IS_AUTHORIZED = 'N';
        $fuelStation->CREATED_BY = Auth::id();

        $added = $fuelStation->save();
        if ($added) {
            return response()->json(['successCode' => 1, 'data' => $fuelStation, 'message' => 'Fuel station successfully added']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add fuel station']);
        }
    }

    /**
     * Get Fuel Station Details
     */
    public function getDetails(Request $request)
    {
        $fuelStationId = $request->fuel_station_id;
        $fuelStation = FuelStation::find($fuelStationId);
        if ($fuelStation)
            return response()->json(['successCode' => 1, 'data' => $fuelStation]);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to get details']);
    }


    /**
     * Update Fuel Station Details in DB
     */
    public function update(Request $request)
    {
        $fuelStationId = $request->fuel_station_id;
        $fuelStation = FuelStation::find($fuelStationId);
        $fuelStation->VENDOR_NAME = $request->vendor_name;
        $fuelStation->FUEL_STATION_NAME = $request->station_name;
        $fuelStation->STATION_CODE =  $request->station_code;
        $fuelStation->AUTHORIZE_PERSON = $request->authorize_person;
        $fuelStation->CONTACT_NUMBER = $request->contact_num;
        if (isset($request->is_authorized))
            $fuelStation->IS_AUTHORIZED = 'Y';
        else
            $fuelStation->IS_AUTHORIZED = 'N';
        $fuelStation->MODIFIED_BY = Auth::id();

        $updated = $fuelStation->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'data' => $fuelStation, 'message' => 'Successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
        }
    }

    /**
     * Activate / De-activate fuel station
     */
    public function statusUpdate(Request $request)
    {
        $fuelStationId = $request->fuel_station_id;
        $fuelStation = FuelStation::find($fuelStationId);

        if ($fuelStation->IS_ACTIVE == 'Y')
            $fuelStation->IS_ACTIVE = 'N';
        else
            $fuelStation->IS_ACTIVE = 'Y';

        $fuelStation->MODIFIED_BY = Auth::id();
        $fuelStation->save();

        return response($fuelStation, 200);
    }
}
