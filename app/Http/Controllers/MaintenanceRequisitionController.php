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
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
            // Return list of all maintenance requisitions as JSON to populated Data Table
            $maintenance_type = $request->mainten_type;
            $status = $request->status;
            $vehicle = $request->vehicle;
            $maintenance_service = $request->mainten_service;
            $serviceFromDate = $request->from;
            $serviceToDate = $request->to;

            $mainten_reqs = DB::table('maintenance_requisitions')
                ->join('vehicles', 'maintenance_requisitions.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
                ->join('mstr_maintenance', 'maintenance_requisitions.MAINTENANCE_TYPE', '=', 'mstr_maintenance.MAINTENANCE_ID')
                ->join('maintenance_services', 'maintenance_requisitions.MAINTENANCE_SERVICE_NAME', '=', 'maintenance_services.MAINTENANCE_SERVICE_ID')
                ->join('mstr_priority', 'maintenance_requisitions.PRIORITY', '=', 'mstr_priority.PRIORITY_ID')
                ->select(
                    'maintenance_requisitions.*',
                    'vehicles.VEHICLE_NAME as VEHICLE_NAME',
                    'mstr_maintenance.MAINTENANCE_NAME as MAINTENANCE_NAME',
                    'maintenance_services.MAINTENANCE_SERVICE_NAME as SERVICE_NAME',
                    'mstr_priority.PRIORITY_NAME as PRIORITY'
                )
                ->when($maintenance_type, function ($query, $maintenance_type) {
                    return $query->where('maintenance_requisitions.MAINTENANCE_TYPE', '=', $maintenance_type);
                })
                ->when($status, function ($query, $status) {
                    return $query->where('maintenance_requisitions.APPROVAL_STATUS', '=', $status);
                })
                ->when($vehicle, function ($query, $vehicle) {
                    return $query->where('maintenance_requisitions.VEHICLE_ID', '=', $vehicle);
                })
                ->when($maintenance_service, function ($query, $maintenance_service) {
                    return $query->where('maintenance_requisitions.MAINTENANCE_SERVICE_NAME', '=', $maintenance_service);
                })
                ->when($serviceFromDate, function ($query, $serviceFromDate) {
                    return $query->where('maintenance_requisitions.SERVICE_DATE', '>=', $serviceFromDate);
                })
                ->when($serviceToDate, function ($query, $serviceToDate) {
                    return $query->where('maintenance_requisitions.SERVICE_DATE', '<=', $serviceToDate);
                })
                ->get();

            return $mainten_reqs->toJson();
        } else {
            $maintenanceTypes = MaintenanceType::all();
            $maintenanceServices = MaintenanceService::all();
            $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
            // Whether to have new table for status instead of phases
            $statuses = Phase::all();
            return view('maintenance.maintenance-requisition', compact('maintenanceTypes', 'maintenanceServices', 'vehicles', 'statuses'));
        }
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

        //Add remarks column
        // $maintenRequisition->REMARKS = $request->remarks;
        $maintenRequisition->CHARGE = $request->charge ?? "";
        $maintenRequisition->CHARGE_BEAR_BY = $request->charge_bear_by ?? "";
        $maintenRequisition->TOTAL_AMOUNT = $request->grand_total_price; // Or use session stored value
        $maintenRequisition->PRIORITY = $request->priority;
        $maintenRequisition->IS_SCHEDULED = $request->is_add_schedule ? 'Y' : 'N';
        $maintenRequisition->CREATED_BY = Auth::id();

        // dd($items, $qty, $rates, $qty, $total_prices, $item_names, count($items), $maintenRequisition);
        $entrySaved = $maintenRequisition->save(); // Set to Boolean based on whether entry was saved
        $maintenReqId = $maintenRequisition->MAINTENANCE_REQ_ID; //->id did not work

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
                        // 'IS_ACTIVE' = 'Y',
                        'CREATED_BY' => Auth::id(),
                        'CREATED_ON' => date('Y-m-d H:i:s')
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
        $maintenRequisition = MaintenanceRequisition::where('MAINTENANCE_REQ_ID', '=', $mainten_req_id)
            ->join('vehicles', 'maintenance_requisitions.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->join('mstr_maintenance', 'maintenance_requisitions.MAINTENANCE_TYPE', '=', 'mstr_maintenance.MAINTENANCE_ID')
            ->join('maintenance_services', 'maintenance_requisitions.MAINTENANCE_SERVICE_NAME', '=', 'maintenance_services.MAINTENANCE_SERVICE_ID')
            ->join('mstr_priority', 'maintenance_requisitions.PRIORITY', '=', 'mstr_priority.PRIORITY_ID')
            ->select(
                'maintenance_requisitions.*',
                'vehicles.VEHICLE_NAME as VEHICLE_NAME',
                'mstr_maintenance.MAINTENANCE_NAME as MAINTENANCE_NAME',
                'maintenance_services.MAINTENANCE_SERVICE_NAME as SERVICE_NAME',
                'mstr_priority.PRIORITY_NAME as REQ_PRIORITY'
            )
            ->first();


        // $maintenRequisition = json_decode(json_encode($maintenRequisition));
        // dd($maintenRequisition);

        // Get Details of Items connected to requisition from Items Table
        $requestedItems = DB::table('maintenance_req_items')->where('MAINTENANCE_REQ_ID', $mainten_req_id)->get();
        // dd($requestedItems);

        // Details returned in Invoice Format to client
        $editURL = route('maintenance-requisitions.edit', ['requisition' => $mainten_req_id]);

        $requisitionDetails = '<div class="row-justify content-center">';
        $requisitionDetails .= '<div class="col-sm-12" id="printin"><div class="col-auto">';
        $requisitionDetails .= '<a href="';
        $requisitionDetails .= $editURL;
        $requisitionDetails .= '" class="btn btn-success ml-2"><i class="typcn typcn-edit mr-1"></i>Edit Maintenance </a></div>';
        $requisitionDetails .= ' <div class="card card-body p-5"><div class="row"><div class="col-12 col-md-6"><p class="text-muted mb-4">';
        $requisitionDetails .= '<strong>Requisition Type</strong>: ';
        $requisitionDetails .= $maintenRequisition->REQUISITION_TYPE == 'M' ? 'Maintenance' : 'General';
        $requisitionDetails .= '<br> <strong>Vehicle Name</strong>: ';
        $requisitionDetails .= $maintenRequisition->VEHICLE_NAME . '<br>';
        $requisitionDetails .= '<strong>Maintenance Type</strong>: ';
        $requisitionDetails .= $maintenRequisition->MAINTENANCE_NAME . '<br>';
        $requisitionDetails .= '<strong>Maintenance Service Name</strong>: ';
        $requisitionDetails .= $maintenRequisition->SERVICE_NAME . '<br>';
        $requisitionDetails .= '</p></div>';
        $requisitionDetails .= '<div class="col-12 col-md-6 text-md-right"><p class="text-muted mb-4">';
        $requisitionDetails .= '<strong>Charge</strong>: ';
        $requisitionDetails .= $maintenRequisition->CHARGE . '<br>';
        $requisitionDetails .= '<strong>Charge Bear By</strong>: ';
        $requisitionDetails .= $maintenRequisition->CHARGE_BEAR_BY . '<br>';
        $requisitionDetails .= '<strong>Priority</strong>: ';
        $requisitionDetails .= $maintenRequisition->REQ_PRIORITY . '<br>';
        $requisitionDetails .= '<p><h6 class="text-uppercase text-muted fs-12 font-weight-600">Service Date</h6>';
        $requisitionDetails .= '<p class="mb-4"><time datetime="' . $maintenRequisition->SERVICE_DATE . '">' . $maintenRequisition->SERVICE_DATE . '</time></p>';
        $requisitionDetails .= '</div></div>';
        $requisitionDetails .= '<div class="row"><div class="col-12"><div class="table-responsive"><table class="table my-4">';
        $requisitionDetails .= '<thead>
        <tr>
            <th class="px-0 bg-transparent border-top-0">
                <span class="h6 font-weight-bold">Item Type</span>
            </th>
            <th class="px-0 bg-transparent border-top-0">
                <span class="h6 font-weight-bold">Item Name</span>
            </th>
            <th class="px-0 bg-transparent border-top-0">
                <span class="h6 font-weight-bold">Item Unit</span>
            </th>
            <th class="px-0 bg-transparent border-top-0">
                <span class="h6 font-weight-bold">Unit Price</span>
            </th>
            <th class="px-0 bg-transparent border-top-0 text-right">
                <span class="h6 font-weight-bold">Total Amount</span>
            </th>
        </tr>
    </thead>';

        $requisitionDetails .= '<tbody>';
        foreach ($requestedItems as $item) {
            $requisitionDetails .= '<tr>';
            $requisitionDetails .= '<td class="px-0">' . $item->ITEM_TYPE_NAME . '</td>';
            $requisitionDetails .= '<td class="px-0 text-center">' . $item->ITEM_NAME . '</td>';
            $requisitionDetails .= '<td class="px-0 text-center">' . $item->UNITS . '</td>';
            $requisitionDetails .= '<td class="px-0 text-center">' . $item->UNIT_PRICE . '</td>';
            $requisitionDetails .= '<td class="px-0 text-right">' . $item->TOTAL_AMOUNT . '</td>';
            $requisitionDetails .= '</tr>';
        }
        $requisitionDetails .= '<tr><td class="px-0 border-top border-top-2"><strong>Total Amount</strong></td>';
        $requisitionDetails .= ' <td colspan="4" class="px-0 text-right border-top border-top-2"><span class="fs-16 font-weight-600">';
        $requisitionDetails .=  $maintenRequisition->TOTAL_AMOUNT . '</span></td></tr>';
        $requisitionDetails .= '</tbody>';
        $requisitionDetails .= '</table>';

        $requisitionDetails .= '</div></div></div></div></div></div>';
        return $requisitionDetails;
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

    /**
     * Return listing of all Maintenance Requistion Approval Authorities
     */
    public function approvalAuthorities()
    {
        return view('maintenance.maintenance-approval-authorities');
    }

    /**
     * Add Maintenance Requsitioin Approval Authority
     */
    public function addApprovalAuthority(Request $request)
    {
    }

    /**
     * Update Maintenance Approval Authority Details
     */
    public function updateApprovalAuthority(Request $request)
    {
    }

    /**
     * Activate / De-activate Approval Authority
     */
    public function changeActivationOfApprovalAuthority(Request $request)
    {
    }
}
