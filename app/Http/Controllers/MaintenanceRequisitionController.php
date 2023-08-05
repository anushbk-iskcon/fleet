<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequisition;
use App\Models\MaintenanceService;
use App\Models\MaintenanceType;
use App\Models\Phase;
use App\Models\Priority;
use App\Models\Vehicle;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $items = $request->product_name;
        $item_names = $request->pitem;
        $qty = $request->product_quantity;
        $rates = $request->product_rate;
        $total_prices = $request->total_price;

        $num_of_items = count($items);
        // dd($items, $qty, $rates, $qty, $total_prices, $item_names, count($items));
        $maintenRequisition = new MaintenanceRequisition;
        $maintenRequisition->REQUISITION_TYPE = $request->req_type ?? 'M';
        $maintenRequisition->REQUISITION_FOR = $request->requested_by;
        $maintenRequisition->VEHICLE_ID = $request->vehicle_name;
        $maintenRequisition->MAINTENANCE_TYPE = $request->mainten_type;
        $maintenRequisition->MAINTENANCE_SERVICE_NAME = $request->mainten_service_name;
        $maintenRequisition->SERVICE_DATE = $request->service_date;
        $maintenRequisition->CHARGE = $request->charge ?? "";
        $maintenRequisition->CHARGE_BEAR_BY = $request->charge_bear_by ?? "";
        $maintenRequisition->TOTAL_AMOUNT = $request->grand_total_price; // Or use session stored value
        $maintenRequisition->PRIORITY = $request->priority;
        $maintenRequisition->IS_SCHEDULED = $request->is_add_schedule ? 'Y' : 'N';
        $maintenRequisition->CREATED_BY = Auth::id();

        dd($items, $qty, $rates, $qty, $total_prices, $item_names, count($items), $maintenRequisition);
        $entrySaved = $maintenRequisition->save(); // Set to Boolean based on whether entry was saved
        $maintenReqId = $maintenRequisition->id;

        // Add all items required to Maintenance Requisition Items Table
        $itemsSaved = false;
        if ($num_of_items) {
            for ($i = 0; $i < $num_of_items; $i++) {
                $currentId = DB::table('maintenance_req_items')->insertGetId(
                    [
                        'MAINTENANCE_REQ_ID' => $maintenReqId,
                        'ITEM_TYPE_NAME' => $items[$i],
                        'ITEM_NAME' => $item_names[$i],
                        'UNITS' => $qty[$i],
                        'UNIT_PRICE' => $rates[$i],
                        'TOTAL_AMOUNT' => $total_prices[$i],
                        'CREATED_BY' => Auth::id()
                    ]
                );
                if ($currentId) $itemsSaved = true;
                else $itemsSaved = false;
            }
        }

        // To return successCode and message/data
        if ($entrySaved && $itemsSaved) {
            return redirect()->route('maintenance-requisitions')->with('message', "Requisition details successfully saved");
        } else {
            return back()->withInput()->with('message', 'Could not save requisition details. Please try again');
        }
    }

    /**
     * Get details of specified Maintenance Requisition
     */
    public function getDetails(Request $request)
    {
        // Get Requisition Details from Requisitions Table
        $mainten_req_id = $request->mainten_req_id;
        $maintenRequisition = MaintenanceRequisition::find($mainten_req_id);

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
        $mainten_req_id = $request->mainten_req_id;
        $maintenRequisition = MaintenanceRequisition::find($mainten_req_id);

        $maintenRequisition->REQUISITION_TYPE = $request->req_type;
        $maintenRequisition->REQUISITION_FOR = $request->requested_by;
        $maintenRequisition->VEHICLE_ID = $request->vehicle_name;
        $maintenRequisition->MAINTENANCE_TYPE = $request->mainten_type;
        $maintenRequisition->MAINTENANCE_SERVICE_NAME = $request->mainten_service_name;
        $maintenRequisition->SERVICE_DATE = $request->service_date;
        $maintenRequisition->CHARGE = $request->charge ?? "";
        $maintenRequisition->CHARGE_BEAR_BY = $request->charge_bear_by ?? "";
        $maintenRequisition->TOTAL_AMOUNT = $request->total_amount; // Or use session stored value
        $maintenRequisition->PRIORITY = $request->priority;
        $maintenRequisition->IS_SCHEDULED = $request->is_add_schedule ? 'Y' : 'N';

        $maintenReqUpdated = $maintenRequisition->save(); // Set to Boolean based on whether entry was saved

        // Update items connected to Requisition
    }

    /**
     * Deactivate / Activate Requisition
     */
    public function changeActivationStatus(Request $request)
    {
        $mainten_req_id = $request->mainten_req_id;
        $maintenRequisition = MaintenanceRequisition::find($mainten_req_id);

        $currentStatus = $maintenRequisition->IS_ACTIVE;
        $maintenRequisition->IS_ACTIVE = $currentStatus == 'Y' ? 'N' : 'Y';
        $maintenRequisition->MODIFIED_BY = Auth::id();
        // Save changes
        return response($maintenRequisition, 200);
    }

    /**
     * Change Approval Status of the Requisition
     */
    public function approvalStatusUpdate(Request $request)
    {
        $mainten_req_id = $request->mainten_req_id;
        $maintenRequisition = MaintenanceRequisition::find($mainten_req_id); // Find by Id
        // Change status based on flag value in request

        $maintenRequisition->MODIFIED_BY = Auth::id();
        // Save changes
        $maintenRequisition->save();
    }
}
