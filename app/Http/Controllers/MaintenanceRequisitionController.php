<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceService;
use App\Models\MaintenanceType;
use App\Models\Phase;
use App\Models\Priority;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use stdClass;

class MaintenanceRequisitionController extends Controller
{
    //
    /**
     * Return view listing all Maintenance Requisitions
     */
    public function index()
    {
        $maintenanceTypes = MaintenanceType::all();
        $maintenanceServices = MaintenanceService::all();
        $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
        // Whether to have new table for status instead of phases
        $statuses = Phase::all();
        return view('maintenance.maintenance-requisition', compact('maintenanceTypes', 'maintenanceServices', 'vehicles', 'statuses'));
    }

    /**
     * Show Page to Add New Maintenance Requisition
     */
    public function create()
    {
        $maintenanceTypes = MaintenanceType::all();
        $maintenanceServices = MaintenanceService::all();
        $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
        $priorities = Priority::all();
        return view('maintenance.add-maintenance-list', compact('maintenanceTypes', 'maintenanceServices', 'vehicles', 'priorities'));
    }

    /**
     * Add newly created Maintenance Requisition to DB
     */
    public function store(Request $request)
    {
        $maintenRequisition = new stdClass;
        $maintenRequisition->REQ_TYPE = $request->req_type;
        $maintenRequisition->REQ_FOR = $request->requested_by;
        $maintenRequisition->VEHICLE = $request->vehicle_name;
        $maintenRequisition->MAINTEN_TYPE = $request->mainten_type;
        $maintenRequisition->MAINTEN_SERVICE_NAME = $request->mainten_service_name;
        $maintenRequisition->SERVICE_DATE = $request->service_date;
        $maintenRequisition->CHARGE = $request->charge ?? "";
        $maintenRequisition->CHARGE_BEAR_BY = $request->charge_bear_by ?? "";
        $maintenRequisition->PRIORITY = $request->priority;
        $maintenRequisition->IS_ACTIVE = $request->is_active;

        $entrySaved = ''; // Set to Boolean based on whether entry was saved

        // Add all items required to Maintenance Requisition Items Table
        $itemsSaved = '';
    }

    /**
     * Get details of specified Maintenance Requisition
     */
    public function getDetails(Request $request)
    {
        // Get Requisition Details from Requisitions Table

        // Get Items connected to requisition from Items Table
    }

    /**
     * Show page to edit details of specified Maintenance Requisition
     */
    public function edit(Request $request)
    {
        $maintenanceTypes = MaintenanceType::all();
        $maintenanceServices = MaintenanceService::all();
        $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
        $priorities = Priority::all();
        return view('maintenance.edit-maintenance-list', compact('maintenanceTypes', 'maintenanceServices', 'vehicles', 'priorities'));
    }

    /**
     * Update Maintenance Requistion Details in DB
     */
    public function update(Request $request)
    {
    }

    /**
     * Deactivate / Activate Requisition
     */
    public function changeActivationStatus(Request $request)
    {
    }

    /**
     * Change Approval Status of the Requisition
     */
    public function approvalStatusUpdate(Request $request)
    {
    }
}
