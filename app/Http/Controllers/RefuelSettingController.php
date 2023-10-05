<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Fuel;
use App\Models\FuelStation;
use App\Models\RefuelSetting;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $refuelSettings = DB::table('refuel_setting')
                ->join('vehicles', 'refuel_setting.VEHICLE', '=', 'vehicles.VEHICLE_ID')
                ->join('drivers', 'refuel_setting.DRIVER', '=', 'drivers.DRIVER_ID')
                ->join('mstr_fuel', 'refuel_setting.FUEL_TYPE', '=', 'mstr_fuel.FUEL_ID')
                ->join('mstr_fuel_station', 'refuel_setting.FUEL_STATION', '=', 'mstr_fuel_station.FUEL_STATION_ID')
                ->select('refuel_setting.*', 'vehicles.VEHICLE_NAME as VEHICLE_NAME', 'drivers.DRIVER_NAME', 'mstr_fuel.FUEL_TYPE_NAME')
                ->get();

            return $refuelSettings->toJson();
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
        $refuelSetting = new RefuelSetting;
        $refuelSetting->VEHICLE = $request->vehicle;
        $refuelSetting->DRIVER =  $request->driver;
        $refuelSetting->FUEL_TYPE = $request->fuel_type;
        $refuelSetting->DRIVER_MOBILE = $request->driver_mobile; # Column removed from form/view
        $refuelSetting->REFUELED_DATE = $request->refueling_date;
        $refuelSetting->REFUEL_LIMIT_TYPE = $request->refuel_limit_type ?? null; # Column removed from form/view
        $refuelSetting->FUEL_STATION = $request->fuel_station;
        $refuelSetting->MAX_UNIT = $request->max_unit; # Column removed from form/view
        $refuelSetting->BUDGET_GIVEN = $request->budget_given ?? 0; # Column removed from form/view
        $refuelSetting->PLACE = $request->place;
        $refuelSetting->KILOMETER_PER_UNIT = $request->kilometer_per_unit ?? 0; # Column removed from form/view
        $refuelSetting->LAST_READING = $request->last_reading ?? null;
        $refuelSetting->LAST_UNIT = $request->last_unit ?? null; # Column removed from form/view
        $refuelSetting->CONSUMPTION_PERCENT = $request->consumption_percent ?? 0; # Column removed from form/view
        $refuelSetting->ODOMETER_DAY_END = $request->odometer_after_day_end ?? null; # Column removed from form/view
        $refuelSetting->ODOMETER_AT_REFUEL = $request->odometer_at_refueling ?? null;
        $refuelSetting->UNIT_TAKEN = $request->unit_taken ?? 0;
        $refuelSetting->STRICT_CONSUMPTION = $request->strict_consumption == 1 ? 'Y' : 'N'; # Option removed from view

        // Add new fields for unit price / total amount
        // $refuelSetting->AMOUNT_PER_UNIT = $request->amount_per_unit ?? 0;
        // $refuelSetting->TOTAL_AMOUNT = $request->total_amount ?? 0;
        // $refuelSetting->SECURITY_NAME = $request->security_name ?? "";

        // For uploading Fuel Slip Image or PDF and storing file path
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '-' . date('Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/refueling/');
            $file->move($uploadDestination, $fileName);
            $refuelSetting->FUEL_SLIP_SCAN_COPY = $fileName;
        }

        $refuelSetting->CREATED_BY = Auth::id();
        $added = $refuelSetting->save(); // Save using Model
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

        # Get details on the Selected Refuel Setting using find(id)
        $refuel_setting_id = $request->refuel_setting_id;
        $refuelSetting = RefuelSetting::find($refuel_setting_id);

        // dd($refuelSetting);

        $editFormContent = '<form id="editRefuelSettingForm" action="' . route('refuel-setting.update') . '" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <input type="hidden" name="_token" value="' . csrf_token() . '">
        <input type="hidden" name="refuel_setting_id" value="' . $refuel_setting_id . '">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="edit_vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <select class="form-control basic-single" required name="vehicle" id="edit_vehicle_name">
                <option value="">Please Select One</option>';
        foreach ($vehicles as $vehicle) {
            if ($refuelSetting->VEHICLE == $vehicle['VEHICLE_ID'])
                $editFormContent .= '<option value="' . $vehicle['VEHICLE_ID'] . '" selected="selected">' . $vehicle['VEHICLE_NAME'] . '</option>';
            else
                $editFormContent .= '<option value="' . $vehicle['VEHICLE_ID'] . '">' . $vehicle['VEHICLE_NAME'] . '</option>';
        }
        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
            <div class="col-sm-7">
            <select class="form-control basic-single" required name="fuel_type" id="edit_fuel_type">
                <option value="">Please Select One</option>';

        foreach ($fuelTypes as $fuelType) {
            if ($refuelSetting->FUEL_TYPE == $fuelType['FUEL_ID'])
                $editFormContent .= '<option value="' . $fuelType['FUEL_ID'] . '" selected="selected">' . $fuelType['FUEL_TYPE_NAME'] . '</option>';
            else
                $editFormContent .= '<option value="' . $fuelType['FUEL_ID'] . '">' . $fuelType['FUEL_TYPE_NAME'] . '</option>';
        }

        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="editdateofrefuel" class="col-sm-5 col-form-label">Refueled Date <i class="text-danger">*</i></label><div class="col-sm-7">
            <input name="refueling_date" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Refueled Date"
            id="editdateofrefuel" value="' . $refuelSetting->REFUELED_DATE . '">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_station_name" class="col-sm-5 col-form-label">Station Name</label>
        <div class="col-sm-7">
            <select class="form-control basic-single" required name="fuel_station" id="edit_station_name">
                <option value="">Please Select One</option>';

        foreach ($fuelStations as $fuelStation) {
            if ($refuelSetting->FUEL_STATION == $fuelStation['FUEL_STATION_ID']) {
                $editFormContent .= '<option value="' . $fuelStation['FUEL_STATION_ID'] . '" selected="selected">' . $fuelStation['VENDOR_NAME'] . " " . $fuelStation['FUEL_STATION_NAME'] . '</option>';
            } else {
                $editFormContent .= '<option value="' . $fuelStation['FUEL_STATION_ID'] . '">' . $fuelStation['VENDOR_NAME'] . " " . $fuelStation['FUEL_STATION_NAME'] . '</option>';
            }
        }
        $editFormContent .= '</select></div></div>';

        // $editFormContent .= '<div class="form-group row">
        // <label for="editbudgetgiven" class="col-sm-5 col-form-label">Budget Given <i class="text-danger">*</i></label>
        // <div class="col-sm-7">
        //     <input name="budget_given" required class="form-control" type="number" placeholder="Budget Given" id="editbudgetgiven" value="' . $refuelSetting->BUDGET_GIVEN . '">
        // </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="editplace" class="col-sm-5 col-form-label">Place <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="place" required class="form-control" type="text" placeholder="Place" id="editplace" value="' . $refuelSetting->PLACE . '">
        </div></div>
        <div class="form-group row">
            <label for="edit_security_name" class="col-sm-5 col-form-label">Security Name </label>
            <div class="col-sm-7">
                <input name="security_name" required class="form-control" type="text" placeholder="Security" id="edit_security_name">
            </div>
        </div>';

        // $editFormContent .= '<div class="form-group row"><label for="edit_kilometer_per_unit" class="col-sm-5 col-form-label">Kilometer Per Unit <i class="text-danger">*</i></label>
        // <div class="col-sm-7">
        //     <input name="kilometer_per_unit" required class="form-control" type="number" placeholder="Kilometer Per Unit" id="edit_kilometer_per_unit" value="' . $refuelSetting->KILOMETER_PER_UNIT . '">
        // </div></div>';

        $editFormContent .= '<div class="form-group row"><label for="edit_last_reading" class="col-sm-5 col-form-label">Last Reading </label>
        <div class="col-sm-7">
            <input name="last_reading" class="form-control" type="number" placeholder="Last Reading" id="edit_last_reading" value="' . $refuelSetting->LAST_READING . '">
        </div></div>';

        // $editFormContent .= '<div class="form-group row"><label for="edit_last_unit" class="col-sm-5 col-form-label">Last Unit </label>
        // <div class="col-sm-7"><input name="last_unit" class="form-control" type="number" placeholder="Last Unit" id="edit_last_unit" value="' . $refuelSetting->LAST_UNIT . '">
        // </div></div></div>';  
        $editFormContent .= '</div>';
        #End col-md-12 and begin new

        $editFormContent .= '<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="edit_driver_name" class="col-sm-5 col-form-label">Driver Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select class="form-control basic-single" required name="driver" id="edit_driver_name">
                    <option value="">Please Select One</option>';
        foreach ($drivers as $driver) {
            if ($refuelSetting->DRIVER == $driver['DRIVER_ID'])
                $editFormContent .= '<option value="' . $driver['DRIVER_ID'] . '" selected="selected">' . $driver['DRIVER_NAME'] . '</option>';
            else
                $editFormContent .= '<option value="' . $driver['DRIVER_ID'] . '">' . $driver['DRIVER_NAME'] . '</option>';
        }
        $editFormContent .= '</select></div></div>';

        // $editFormContent .= '<div class="form-group row">
        // <label for="edit_driver_mobile" class="col-sm-5 col-form-label">Driver Mobile <i class="text-danger">*</i></label>
        // <div class="col-sm-7">
        //     <input name="driver_mobile" class="form-control" required type="number" placeholder="Driver Mobile" id="edit_driver_mobile" value="' . $refuelSetting->DRIVER_MOBILE . '">
        // </div></div>
        // <div class="form-group row">
        // <label for="edit_refuel_limit_type" class="col-sm-5 col-form-label">Refuel Limit Type </label>
        // <div class="col-sm-7">
        //     <input name="refuel_limit_type" class="form-control" type="text" placeholder="Refuel Limit Type" id="edit_refuel_limit_type" value="' . $refuelSetting->REFUEL_LIMIT_TYPE . '">
        // </div></div>';

        // $editFormContent .= '<div class="form-group row">
        // <label for="edit_max_unit" class="col-sm-5 col-form-label">Max Unit <i class="text-danger">*</i></label>
        // <div class="col-sm-7">
        //     <input name="max_unit" required class="form-control" type="number" placeholder="Max Unit" id="edit_max_unit" value="' . $refuelSetting->MAX_UNIT . '">
        // </div></div>
        // <div class="form-group row">
        // <label for="edit_consumption_percent" class="col-sm-5 col-form-label">Consumption Percent </label>
        // <div class="col-sm-7">
        //     <input name="consumption_percent" class="form-control" type="number" placeholder="Consumption Percent" id="edit_consumption_percent" value="' . $refuelSetting->CONSUMPTION_PERCENT . '">
        // </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_odometer_at_time_of_refueling" class="col-sm-5 col-form-label">Odometer at time of refueling </label>
        <div class="col-sm-7">
            <input name="odometer_at_refueling" class="form-control" type="number" placeholder="Odometer at time of refueling" id="edit_odometer_at_time_of_refueling" value="' . $refuelSetting->ODOMETER_AT_REFUEL . '">
        </div></div>';

        $editFormContent .= '<div class="form-group row">
        <label for="edit_unit_taken" class="col-sm-5 col-form-label">Unit Taken <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="unit_taken" class="form-control" type="number" placeholder="Unit Taken" id="edit_unit_taken" value="' . $refuelSetting->UNIT_TAKEN . '">
        </div></div>
        <div class="form-group row">
            <label for="edit_amount_per_unit" class="col-sm-5 col-form-label">Amount Per Unit (INR)</label>
            <div class="col-sm-7">
                <input type="number" name="amount_per_unit" class="form-control" placeholder="Amount Per Unit (INR)" id="edit_amount_per_unit">
            </div>
        </div>
        <div class="form-group row">
            <label for="edit_total_amount" class="col-sm-5 col-form-label">Total Amount (INR)</label>
            <div class="col-sm-7">
                <input type="number" name="total_amount" class="form-control" placeholder="Total Amount (INR)" id="edit_total_amount">
            </div>
        </div>
        <div class="form-group row">
        <label for="edit_picture" class="col-sm-5 col-form-label">Fuel Slip Scan Copy </label>
        <div class="col-sm-7">
            <input type="file" accept="image/*" name="picture">
        </div></div>';

        $editFormContent .= '<div class="form-group text-right">
        <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditForm">Reset</button>
        <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
        </div></div>
        </form>';

        return $editFormContent;
    }

    /**
     * Update Refuel Setting Details in DB
     */
    public function update(Request $request)
    {
        $refuel_setting_id = $request->refuel_setting_id;
        $refuelSetting = RefuelSetting::find($refuel_setting_id);

        $refuelSetting->VEHICLE = $request->vehicle;
        $refuelSetting->DRIVER =  $request->driver;
        $refuelSetting->FUEL_TYPE = $request->fuel_type;
        $refuelSetting->DRIVER_MOBILE = $request->driver_mobile ?? ""; # Column removed from view/form
        $refuelSetting->REFUELED_DATE = $request->refueling_date;
        $refuelSetting->REFUEL_LIMIT_TYPE = $request->refuel_limit_type ?? null; # Column removed from view
        $refuelSetting->FUEL_STATION = $request->fuel_station ?? 0;
        $refuelSetting->MAX_UNIT = $request->max_unit; # Column removed from view
        $refuelSetting->BUDGET_GIVEN = $request->budget_given ?? 0; # Column removed from view
        $refuelSetting->PLACE = $request->place;
        $refuelSetting->KILOMETER_PER_UNIT = $request->kilometer_per_unit ?? 0; # Column removed from view
        $refuelSetting->LAST_READING = $request->last_reading ?? null;
        $refuelSetting->LAST_UNIT = $request->last_unit ?? null; # Column removed from view
        $refuelSetting->CONSUMPTION_PERCENT = $request->consumption_percent ?? 0; # Column removed from view
        $refuelSetting->ODOMETER_DAY_END = $request->odometer_after_day_end ?? null; # Column removed from view
        $refuelSetting->ODOMETER_AT_REFUEL = $request->odometer_at_refueling ?? null;
        $refuelSetting->UNIT_TAKEN = $request->unit_taken ?? 0;
        $refuelSetting->STRICT_CONSUMPTION = $request->strict_consumption == 1 ? 'Y' : 'N'; # Option removed from view

        // Newly added fields
        // $refuelSetting->AMOUNT_PER_UNIT = $request->amount_per_unit ?? 0;
        // $refuelSetting->TOTAL_AMOUNT = $request->total_amount ?? 0;
        // $refuelSetting->SECURITY_NAME = $request->security_name ?? "";

        // For uploading Fuel Slip Image or PDF and storing file path
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '-' . date('Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/refueling/');
            $file->move($uploadDestination, $fileName);
            $refuelSetting->FUEL_SLIP_SCAN_COPY = $fileName;
        }

        $refuelSetting->MODIFIED_BY = Auth::id();
        $updated = $refuelSetting->save(); // Save using Model
        if ($updated)
            return response()->json(['successCode' => 1, 'message' => 'Refuel setting successfully updated']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Could not update refuel setting']);
    }

    /**
     * Activate / De-activate Refuel Setting
     */
    public function activationStatusChange(Request $request)
    {
        $refuel_setting_id = $request->refuel_setting_id;
        $new_activation_status = $request->activation_status;
        $refuelSetting = RefuelSetting::find($refuel_setting_id);
        $activationStatus = ($new_activation_status == 1) ? 'Y' : 'N';
        $refuelSetting->IS_ACTIVE = $activationStatus;
        $refuelSetting->MODIFIED_BY = Auth::id();

        $statusChanged = $refuelSetting->save();
        if ($statusChanged)
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Could not update active status']);
    }
}
