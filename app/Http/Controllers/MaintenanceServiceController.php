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
            $services = DB::table('maintenance_services')
                ->join('mstr_maintenance', 'maintenance_services.MAINTENANCE_SERVICE_ID', '=', 'mstr_maintenance.MAINTENANCE_ID')
                ->select('maintenance_services.*', 'mstr_maintenance.MAINTENANCE_NAME')
                ->get();
            return $services->toJson();
        } else {
            $services = DB::table('maintenance_services')
                ->join('mstr_maintenance', 'maintenance_services.MAINTENANCE_SERVICE_ID', '=', 'mstr_maintenance.MAINTENANCE_ID')
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
     * Update Maintenance Service details in DB
     */
    public function update(Request $request)
    {
        $serviceId = $request->mainten_service_id;
        $maintenanceService = MaintenanceService::find($serviceId);
        $maintenanceService->MAINTENANCE_SERVICE_NAME = $request->service_name;
        $maintenanceService->SERVICE_TYPE = $request->service_type;
        $maintenanceService->TRACK_BY_DATE = $request->track_bydate;
        $maintenanceService->FUEL_TRACKING = $request->fuel_tracking;
        $maintenanceService->MILAGE_TRACKING = $request->milage_tracking;
        $maintenanceService->IS_ACTIVE = $request->is_active ?? "Y";
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
