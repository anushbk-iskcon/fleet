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
        $refuelSetting->REFUEL_LIMIT_TYPE = $request->refuel_limit_type ?? "";
        $refuelSetting->FUEL_STATION = $request->fuel_station;
        $refuelSetting->MAX_UNIT = $request->max_unit;
        $refuelSetting->BUDGET_GIVEN = $request->budget_given;
        $refuelSetting->PLACE = $request->place;
        $refuelSetting->KILOMETER_PER_UNIT = $request->kilometer_per_unit;
        $refuelSetting->LAST_READING = $request->last_reading ?? "";
        $refuelSetting->LAST_UNIT = $request->last_unit ?? null;
        $refuelSetting->CONSUMPTION_PERCENT = $request->consumption_percent ?? "";
        $refuelSetting->ODOMETER_DAY_END = $request->odometer_after_day_end ?? "";
        $refuelSetting->ODOMETER_AT_REFUEL = $request->odometer_at_refueling ?? "";
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
     * Get Details and Send Pre-filled data to Edit Form
     */
    public function edit(Request $request)
    {
        # Get all master data for the form
        $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get(['VEHICLE_ID', 'VEHICLE_NAME']);
        $fuelTypes = Fuel::where('IS_ACTIVE', 'Y')->get(['FUEL_ID', 'FUEL_TYPE_NAME']);
        $fuelStations = FuelStation::where('IS_ACTIVE', 'Y')->get(['FUEL_STATION_ID', 'VENDOR_NAME', 'FUEL_STATION_NAME']);
        $drivers = Driver::where('IS_ACTIVE', 'Y')->get(['DRIVER_ID', 'DRIVER_NAME']);

        # +ADD CODE TO Get details on the Selected Refuel Setting using find(id)

        $editFormContent = '<div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="edit_vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <select class="form-control basic-single" required name="vehicle" id="edit_vehicle_name">
                <option value="">Please Select One</option>';
        foreach ($vehicles as $vehicle) {
            $editFormContent .= '<option value="' . $vehicle['VEHICLE_ID'] . '">' . $vehicle['VEHICLE_NAME'] . '</option>';
        }
        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
            <div class="col-sm-7">
            <select class="form-control basic-single" required name="fuel_type" id="edit_fuel_type">
                <option value="" selected="selected">Please Select One</option>';

        foreach ($fuelTypes as $fuelType) {
            $editFormContent .= '<option value="' . $fuelType['FUEL_ID'] . '">' . $fuelType['FUEL_TYPE_NAME'] . '</option>';
        }

        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="editdateofrefuel" class="col-sm-5 col-form-label">Refueled Date </label><div class="col-sm-7">
            <input name="refueling_date" autocomplete="off" class="form-control newdatetimepicker" type="text" value="" placeholder="Refueled Date" id="editdateofrefuel">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_station_name" class="col-sm-5 col-form-label">Station Name <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <select class="form-control basic-single" required name="fuel_station" id="edit_station_name">
                <option value="">Please Select One</option>';

        foreach ($fuelStations as $fuelStation) {
            $editFormContent .= '<option value="' . $fuelStation['FUEL_STATION_ID'] . '">' . $fuelStation['VENDOR_NAME'] . " " . $fuelStation['FUEL_STATION_NAME'] . '</option>';
        }
        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="editbudgetgiven" class="col-sm-5 col-form-label">Budget Given <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="budget_given" required class="form-control" type="number" placeholder="Budget Given" id="editbudgetgiven" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="editplace" class="col-sm-5 col-form-label">Place <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="place" required class="form-control" type="text" placeholder="Place" id="editplace" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row"><label for="edit_kilometer_per_unit" class="col-sm-5 col-form-label">Kilometer Per Unit <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="kilometer_per_unit" required class="form-control" type="number" placeholder="Kilometer Per Unit" id="edit_kilometer_per_unit" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row"><label for="edit_last_reading" class="col-sm-5 col-form-label">Last Reading </label>
        <div class="col-sm-7">
            <input name="last_reading" class="form-control" type="number" placeholder="Last Reading" id="edit_last_reading" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row"><label for="edit_last_unit" class="col-sm-5 col-form-label">Last Unit </label>
        <div class="col-sm-7"><input name="last_unit" class="form-control" type="number" placeholder="Last Unit" id="edit_last_unit" value="">
        </div></div></div>';  #End col-md-12 and begin new

        $editFormContent .= '<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="edit_driver_name" class="col-sm-5 col-form-label">Driver Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select class="form-control basic-single" required name="driver" id="edit_driver_name">
                    <option value="">Please Select One</option>';
        foreach ($drivers as $driver) {
            $editFormContent .= '<option value="' . $driver['DRIVER_ID'] . '">' . $driver['DRIVER_NAME'] . '</option>';
        }
        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_driver_mobile" class="col-sm-5 col-form-label">Driver Mobile <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="driver_mobile" class="form-control" required type="number" placeholder="Driver Mobile" id="edit_driver_mobile" value="">
        </div></div>
        <div class="form-group row">
        <label for="edit_refuel_limit_type" class="col-sm-5 col-form-label">Refuel Limit Type </label>
        <div class="col-sm-7">
            <input name="refuel_limit_type" class="form-control" type="text" placeholder="Refuel Limit Type" id="edit_refuel_limit_type" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_max_unit" class="col-sm-5 col-form-label">Max Unit <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="max_unit" required class="form-control" type="number" placeholder="Max Unit" id="edit_max_unit" value="">
        </div></div>
        <div class="form-group row">
        <label for="edit_consumption_percent" class="col-sm-5 col-form-label">Consumption Percent </label>
        <div class="col-sm-7">
            <input name="consumption_percent" class="form-control" type="number" placeholder="Consumption Percent" id="edit_consumption_percent" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_odometer_km_after_day_end_stop" class="col-sm-5 col-form-label">Odometer KM after day end stop </label>
        <div class="col-sm-7">
            <input name="odometer_after_day_end" class="form-control" type="number" placeholder="Odometer KM after day end stop" id="edit_odometer_km_after_day_end_stop" value="">
        </div></div>
        <div class="form-group row">
        <label for="edit_odometer_at_time_of_refueling" class="col-sm-5 col-form-label">Odometer at time of refueling </label>
        <div class="col-sm-7">
            <input name="odometer_at_refueling" class="form-control" type="number" placeholder="Odometer at time of refueling" id="edit_odometer_at_time_of_refueling" value="">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_unit_taken" class="col-sm-5 col-form-label">Unit Taken </label>
        <div class="col-sm-7">
            <input name="unit_taken" class="form-control" type="number" placeholder="Unit Taken" id="edit_unit_taken">
        </div></div>
        <div class="form-group row">
        <label for="edit_picture" class="col-sm-5 col-form-label">Fuel Slip Scan Copy </label>
        <div class="col-sm-7">
            <input type="file" accept="image/*" name="picture" onchange="loadFile(event)">
        </div></div>
        <div class="form-group row m-0">
        <label for="" class="col-sm-5 col-form-label">&nbsp; </label>
        <div class="col-sm-7 checkbox checkbox-primary">
            <input id="checkbox_edit_strict" type="checkbox" name="strict_consumption" value="1">
            <label for="checkbox_edit_strict">Strict Consumption Apply</label>
        </div></div>';

        $editFormContent .= '<div class="form-group text-right">
        <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
        <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
        </div></div>';

        return $editFormContent;
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
            return response()->json(['successCode' => 0, 'message' => 'Could not update active status']);
    }
}
