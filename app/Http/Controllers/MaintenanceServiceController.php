<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceService;
use App\Models\MaintenanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceServiceController extends Controller
{
    //
    /**
     * Return listing of all Maintenance Services
     */
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
            $service_type = $request->serv_typesr;
            $service_name = $request->ser_namesr;

            $services = DB::table('maintenance_services')
                ->join('mstr_maintenance', 'maintenance_services.SERVICE_TYPE', '=', 'mstr_maintenance.MAINTENANCE_ID')
                ->select('maintenance_services.*', 'mstr_maintenance.MAINTENANCE_NAME')
                ->when($service_type, function ($query, $service_type) {
                    return $query->where('maintenance_services.SERVICE_TYPE', '=', $service_type);
                })
                ->when($service_name, function ($query, $service_name) {
                    return $query->where('maintenance_services.MAINTENANCE_SERVICE_NAME', 'like', '%' . $service_name . '%');
                })
                ->get();
            return $services->toJson();
        } else {
            $services = DB::table('maintenance_services')
                ->join('mstr_maintenance', 'maintenance_services.SERVICE_TYPE', '=', 'mstr_maintenance.MAINTENANCE_ID')
                ->select('maintenance_services.*', 'mstr_maintenance.MAINTENANCE_NAME')
                ->get();

            // dd($services);
            $serviceTypes = MaintenanceType::all();
            return view('maintenance.maintenance-service-list', compact('services', 'serviceTypes'));
        }
    }

    /**
     * Add new Maintenance Service to DB
     */
    public function store(Request $request)
    {
        $maintenanceService = new MaintenanceService;
        $maintenanceService->MAINTENANCE_SERVICE_NAME = $request->service_name;
        $maintenanceService->SERVICE_TYPE = $request->service_type;
        $maintenanceService->TRACK_BY_DATE = (isset($request->track_bydate)) ? 'Y' : 'N';
        $maintenanceService->FUEL_TRACKING = isset($request->fuel_tracking) ? 'Y' : 'N';
        $maintenanceService->MILAGE_TRACKING = isset($request->milage_tracking) ? 'Y' : 'N';
        $maintenanceService->IS_ACTIVE = isset($request->is_active) ? 'Y' : 'N';
        $maintenanceService->CREATED_BY = Auth::id();
        $added = $maintenanceService->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'New maintenance service created successfully', 'data' => $maintenanceService]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not create maintenance service']);
        }
    }

    /**
     * Return Form for Updating with Pre-filled current data on Maintenance Service
     */
    public function edit(Request $request)
    {
        $serviceId = $request->mainten_service_id;
        $maintenanceService = MaintenanceService::find($serviceId);
        $serviceTypes = MaintenanceType::all();

        // dd($maintenanceService);
        // Return pre-populated form
        $editFormContent = '<input type="hidden" name="mainten_service_id" id="editMaintenServiceId" value="' . $maintenanceService['MAINTENANCE_SERVICE_ID'] . '">';
        $editFormContent .= '<div class="col-md-12 col-lg-6"><div class="form-group row">';
        $editFormContent .= '<label for="new_ser_name" class="col-sm-5 col-form-label">Service Name <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="service_name" required="" class="form-control" type="text"
            placeholder="Service Name" id="new_ser_name" value="' . $maintenanceService['MAINTENANCE_SERVICE_NAME'] . '">
        </div>
        </div>';
        $editFormContent .= '<div class="form-group row">
        <label for="new_serv_type" class="col-sm-5 col-form-label">Service Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
        <select class="form-control" required="" name="service_type" id="new_serv_type">
        <option value="">Please Select One</option>';

        foreach ($serviceTypes as $serviceType) {
            if ($serviceType['MAINTENANCE_ID'] == $maintenanceService['SERVICE_TYPE'])
                $editFormContent .= '<option value="' . $serviceType['MAINTENANCE_ID'] . '" selected>' . $serviceType['MAINTENANCE_NAME'] . '</option>';
            else
                $editFormContent .= '<option value="' . $serviceType['MAINTENANCE_ID'] . '">' . $serviceType['MAINTENANCE_NAME'] . '</option>';
        }
        $editFormContent .= '</select></div></div>';

        $editFormContent .= '<div class="form-group row m-0">
        <label for="new_track_bydate" class="col-sm-5 col-form-label">&nbsp;</label>
        <div class="col-sm-7 checkbox checkbox-primary">
            <input id="checkbox02" type="checkbox" name="new_track_bydate"';
        if ($maintenanceService['TRACK_BY_DATE'] == 'Y')
            $editFormContent .= 'checked="checked">';
        else
            $editFormContent .= '>';
        $editFormContent .= '<label for="checkbox02">Track By Date</label></div></div></div>';

        $editFormContent .= '<div class="col-md-12 col-lg-6">
        <div class="form-group row m-0">
            <label for="new_fuel_tracking" class="col-sm-5 col-form-label">&nbsp;</label>
            <div class="col-sm-7 checkbox checkbox-primary">
                <input id="checkbox03" type="checkbox" name="fuel_tracking" id="new_fuel_tracking" ';
        if ($maintenanceService['FUEL_TRACKING'] == 'Y')
            $editFormContent .= 'checked="checked">';
        else
            $editFormContent .= '>';

        $editFormContent .= '<label for="checkbox03">Fuel Tracking</label></div></div>';

        $editFormContent .= '<div class="form-group row m-0">
            <label for="new_milage_tracking" class="col-sm-5 col-form-label">&nbsp; </label>
            <div class="col-sm-7 checkbox checkbox-primary">
                <input id="checkbox04" type="checkbox" name="new_milage_tracking"';

        if ($maintenanceService['MILAGE_TRACKING'] == 'Y')
            $editFormContent .= 'checked="checked">';
        else
            $editFormContent .= '>';

        $editFormContent .= '<label for="checkbox04">Milage Tracking</label></div></div>
        <div class="form-group row m-0">
            <label for="tolerance" class="col-sm-5 col-form-label">&nbsp;</label>
            <div class="col-sm-7 checkbox checkbox-primary">
                <input id="checkbox05" type="checkbox" name="is_active"';

        if ($maintenanceService['IS_ACTIVE'] == 'Y')
            $editFormContent .= 'checked="checked">';
        else
            $editFormContent .= '>';
        $editFormContent .= '<label for="checkbox05">Is Active</label></div></div>
        <div class="form-group text-right">
            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
        </div></div>';

        return $editFormContent;
    }

    /**
     * Update Maintenance Service details in DB
     */
    public function update(Request $request)
    {
        $serviceId = $request->mainten_service_id;
        $maintenanceService = MaintenanceService::find($serviceId);
        $maintenanceService->MAINTENANCE_SERVICE_NAME = $request->service_name;
        $maintenanceService->SERVICE_TYPE = $request->service_type;
        $maintenanceService->TRACK_BY_DATE = isset($request->track_bydate) ? 'Y' : 'N';
        $maintenanceService->FUEL_TRACKING = isset($request->fuel_tracking) ? 'Y' : 'N';
        $maintenanceService->MILAGE_TRACKING = isset($request->milage_tracking) ? 'Y' : 'N';
        $maintenanceService->IS_ACTIVE = isset($request->is_active) ? "Y" : 'N';
        $maintenanceService->MODIFIED_BY = Auth::id();
        $updated = $maintenanceService->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not update maintenance service']);
        }
    }

    /**
     * Deactivate / activate Maintenance Service in DB
     */
    public function activationStatusUpdate(Request $request)
    {
        $serviceId = $request->mainten_service_id;
        $maintenanceService = MaintenanceService::find($serviceId);

        if ($maintenanceService->IS_ACTIVE == 'Y')
            $maintenanceService->IS_ACTIVE = 'N';
        else
            $maintenanceService->IS_ACTIVE = 'Y';

        $maintenanceService->MODIFIED_BY = Auth::id();
        $maintenanceService->save();

        return response($maintenanceService, 200);
    }
}
