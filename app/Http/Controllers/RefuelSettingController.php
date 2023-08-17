<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Fuel;
use App\Models\FuelStation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class RefuelSettingController extends Controller
{
    //
    /**
     * Return page listing all refuel settings
     */
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
        } else {
            // In case of GET request, return listing page
            $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get(['VEHICLE_ID', 'VEHICLE_NAME']);
            $fuelTypes = Fuel::where('IS_ACTIVE', 'Y')->get(['FUEL_ID', 'FUEL_TYPE_NAME']);
            $fuelStations = FuelStation::where('IS_ACTIVE', 'Y')->get(['FUEL_STATION_ID', 'VENDOR_NAME', 'FUEL_STATION_NAME']);
            $drivers = Driver::where('IS_ACTIVE', 'Y')->get(['DRIVER_ID', 'DRIVER_NAME']);
            return view('refueling.refuel-setting', compact('vehicles', 'fuelTypes', 'fuelStations', 'drivers'));
        }
    }

    /**
     * Add new refueling setting to DB
     */
    public function store(Request $request)
    {
        $refuelSetting = new stdClass;
        $refuelSetting->VEHICLE = $request->vehicle;
        $refuelSetting->DRIVER =  $request->driver;
        $refuelSetting->FUEL_TYPE = $request->fuel_type;
        $refuelSetting->DRIVER_MOBILE = $request->driver_mobile;
        $refuelSetting->REFUELED_DATE = $request->refueling_date;
        $refuelSetting->REFUEL_LIMIT_TYPE = $request->refuel_limit_type;
        $refuelSetting->FUEL_STATION = $request->fuel_station;
        $refuelSetting->MAX_UNIT = $request->max_unit;
        $refuelSetting->BUDGET_GIVEN = $request->budget_given;
        $refuelSetting->PLACE = $request->place;
        $refuelSetting->KILOMETER_PER_UNIT = $request->kilometer_per_unit;
        $refuelSetting->LAST_READING = $request->last_reading;
        $refuelSetting->LAST_UNIT = $request->last_unit;
        $refuelSetting->CONSUMPTION_PERCENT = $request->consumption_percent;
        $refuelSetting->ODOMETER_DAY_END = $request->odometer_after_day_end;
        $refuelSetting->ODOMETER_AT_REFUEL = $request->odometer_at_refueling;
        $refuelSetting->UNIT_TAKEN = $request->unit_taken;
        $refuelSetting->STRICT_CONSUMPTION = $request->strict_consumption == 1 ? 'Y' : 'N';

        // For uploading Fuel Slip Image or PDF and storing file path
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '-' . date('Y') . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/refueling/');
            $file->move($uploadDestination, $fileName);
            $refuelSetting->FUEL_SLIP_SCAN_COPY = $fileName;
        }

        $refuelSetting->CREATED_BY = Auth::id();
        $added = ''; // Save using Model
        if ($added)
            return response()->json(['successCode' => 1, 'message' => 'Refuel setting added successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Could not add refuel setting']);
    }

    /**
     * Update Refuel Setting Details in DB
     */
    public function update(Request $request)
    {
    }

    /**
     * Activate / De-activate Refuel Setting
     */
    public function activationStatusChange(Request $request)
    {
        $refuelSetting = new stdClass;
        $activationStatus = $request->activation_status == 1 ? 'Y' : 'N';
        $refuelSetting->IS_ACTIVE = $activationStatus;
        $refuelSetting->MODIFIED_BY = Auth::id();

        $statusChanged = '';
        if ($statusChanged)
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Could not update active staus']);
    }
}
