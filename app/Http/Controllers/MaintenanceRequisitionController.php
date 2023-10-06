<?php

namespace App\Http\Controllers;

use App\Models\ApprovalAuthority;
use App\Models\HrApi;
use App\Models\MaintenanceRequisition;
use App\Models\MaintenanceService;
use App\Models\MaintenanceType;
use App\Models\Phase;
use App\Models\Priority;
use App\Models\RequisitionType;
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
            // Return list of all maintenance requisitions as JSON to populate Data Table
            $maintenance_type = $request->mainten_type;
            $status = '';
            if ($request->status == 1)  // Based on Values in mstr_phases table
                $status = 'P';
            else if ($request->status == 2)
                $status = 'A';
            else if ($request->status == 3)
                $status = 'R';
            else
                $status = null;
            $vehicle = $request->vehicle;
            $maintenance_service = $request->mainten_service;
            $fromDate = $request->from;
            $toDate = $request->to;
            $serviceFromDate = null;
            $serviceToDate = null;
            if (isset($fromDate))
                $serviceFromDate = date('Y-m-d', strtotime($fromDate));
            if (isset($toDate))
                $serviceToDate = date('Y-m-d', strtotime($toDate));

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

        // Get Employee Names and Departments for slecting employee requisition is done for
        $hrApi = new HrApi;

        $employeeData = $hrApi->getEmployeeList(""); // No parameters sent (dept = "")
        // dd($employeeData);
        return view('maintenance.add-maintenance-list', compact('maintenanceTypes', 'maintenanceServices', 'vehicles', 'priorities', 'employeeData'));
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

        // Store both Requested By Employee ID and Employee Name:
        # select option values are in format employeeId|employeeName
        $requestedBy = $request->requested_by;
        $requester = explode('|', $requestedBy);
        $maintenRequisition->REQUISITION_FOR = $requester[0];
        $maintenRequisition->EMPLOYEE_NAME = $requester[1];

        $maintenRequisition->VEHICLE_ID = $request->vehicle_name;
        $maintenRequisition->MAINTENANCE_TYPE = $request->mainten_type;
        $maintenRequisition->MAINTENANCE_SERVICE_NAME = $request->mainten_service_name;
        $maintenRequisition->SERVICE_DATE = date('Y-m-d', strtotime($request->service_date));
        # Date format YYYY-MM-DD

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

        // To upload scanned copy of invoice
        if ($request->hasFile('mainten_invoice')) {
            $invoice = $request->file('mainten_invoice');
            $document = time() . '-' . date('Y') . '.' . $invoice->getClientOriginalExtension();
            $destination = public_path('/upload/documents/maintenance/');
            $invoice->move($destination, $document);

            // Store filename in DB column:

        }

        // To return successCode and message/data
        if ($entrySaved && $itemsSaved) {
            return redirect()->route('maintenance-requisitions')->with('message', "Requisition details successfully added");
        } else {
            return back()->withInput()->with('message', 'Could not add requisition details. Please try again');
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

        // Get Details of Items connected to requisition from Items Table
        $requestedItems = DB::table('maintenance_req_items')->where('MAINTENANCE_REQ_ID', $mainten_req_id)->where('IS_ACTIVE', 'Y')
            ->get();

        // Details returned in Invoice Format to client
        $editURL = route('maintenance-requisitions.edit', ['requisition' => $mainten_req_id]);

        $requisitionDetails = '<div class="row-justify content-center">';
        $requisitionDetails .= '<div class="col-sm-12" id="printin"><div class="col-auto">';
        $requisitionDetails .= '<a href="';
        $requisitionDetails .= $editURL;
        $requisitionDetails .= '" class="btn btn-success ml-2"><i class="typcn typcn-edit mr-1"></i>Edit Maintenance </a></div>';
        $requisitionDetails .= ' <div class="card card-body p-5"><div class="row"><div class="col-12 col-md-6"><p class="text-muted mb-4">';
        $requisitionDetails .= '<strong>Requisition Type</strong>: ';
        $requisitionDetails .= $maintenRequisition->REQUISITION_TYPE == 'M' ? 'Breakdown' : 'Periodic';
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
        $requisitionDetails .= '<p class="mb-4"><time datetime="' . $maintenRequisition->SERVICE_DATE . '">' . date('d-M-Y', strtotime($maintenRequisition->SERVICE_DATE)) . '</time></p>';
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
            $requisitionDetails .= '<td class="px-0">' . $item->ITEM_NAME . '</td>';
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
    public function edit(Request $request, $requisition)
    {
        // Get master data
        $maintenanceTypes = MaintenanceType::all();
        $maintenanceServices = MaintenanceService::all();
        $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
        $priorities = Priority::all();

        // Get requisition details
        $maintenReqDetails = MaintenanceRequisition::where('MAINTENANCE_REQ_ID', $requisition)
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

        // Get details of items connected to requisition
        $requestedItems = DB::table('maintenance_req_items')->where('MAINTENANCE_REQ_ID', $requisition)->where('IS_ACTIVE', 'Y')->get();

        // Get employee names
        $hrApi = new HrApi;
        $employeeData = $hrApi->getEmployeeList(""); // No parameters sent to get all employees from all departments (dept = "")

        return view('maintenance.edit-maintenance-list', compact(
            'maintenanceTypes',
            'maintenanceServices',
            'vehicles',
            'priorities',
            'maintenReqDetails',
            'requestedItems',
            'employeeData'
        ));
    }

    /**
     * Update Maintenance Requistion Details in DB
     */
    public function update(Request $request)
    {
        $mainten_req_id = $request->mainten_req_id;
        $maintenRequisition = MaintenanceRequisition::find($mainten_req_id);

        $maintenRequisition->REQUISITION_TYPE = $request->req_type ?? "M";

        // To Store both Requested By Employee ID and Employee Name:
        # select option values are in format employeeId|employeeName
        $requestedBy = $request->requested_by;
        $requester = explode('|', $requestedBy);
        $maintenRequisition->REQUISITION_FOR = $requester[0];
        $maintenRequisition->EMPLOYEE_NAME = $requester[1];

        $maintenRequisition->VEHICLE_ID = $request->vehicle_name;
        $maintenRequisition->MAINTENANCE_TYPE = $request->mainten_type;
        $maintenRequisition->MAINTENANCE_SERVICE_NAME = $request->mainten_service_name;
        $maintenRequisition->SERVICE_DATE = date('Y-m-d', strtotime($request->service_date));
        $maintenRequisition->CHARGE = $request->charge ?? "";
        $maintenRequisition->CHARGE_BEAR_BY = $request->charge_bear_by ?? "";
        $maintenRequisition->TOTAL_AMOUNT = $request->grand_total_price; // Or use session stored value
        $maintenRequisition->PRIORITY = $request->priority;
        $maintenRequisition->IS_SCHEDULED = $request->is_add_schedule ? 'Y' : 'N';
        $maintenRequisition->MODIFIED_BY = Auth::id();

        $maintenReqUpdated = $maintenRequisition->save(); // Set to Boolean based on whether entry was saved

        // Get items currently connected to Requisition (before update)
        $prevItemIds = DB::table('maintenance_req_items')->where('MAINTENANCE_REQ_ID', $mainten_req_id)->pluck('ITEM_ID');

        // Update items connected to Requisition
        $itemsUpdated = false;
        $items = $request->product_name;
        $itemIds = $request->item_id;
        $item_names = $request->pitem;
        $qty = $request->product_quantity;
        $rates = $request->product_rate;
        $total_prices = $request->total_price;

        $num_items = count($items);
        // Update any items where details were changed
        for ($i = 0; $i < $num_items; $i++) {
            if ($itemIds[$i] != '' || $itemIds[$i] != null) {
                // If ID for index (form row) is not null, that entry currently exists in DB table, has to be updated
                DB::table('maintenance_req_items')->where('ITEM_ID', $itemIds[$i])
                    ->update([
                        'ITEM_TYPE_NAME' => $items[$i],
                        'ITEM_NAME' => $item_names[$i],
                        'UNITS' => $qty[$i],
                        'UNIT_PRICE' => $rates[$i],
                        'TOTAL_AMOUNT' => $total_prices[$i],
                        'MODIFIED_BY' => Auth::id(),
                        'MODIFIED_ON' => date('Y-m-d H:i:s')
                    ]);
            } else {
                // If ID for Item doesn't exist in DB table, it was newly added in form, should be inserted to DB
                DB::table('maintenance_req_items')->insert([
                    'MAINTENANCE_REQ_ID' => $mainten_req_id,
                    'ITEM_TYPE_NAME' => $items[$i],
                    'ITEM_NAME' => $item_names[$i],
                    'UNITS' => $qty[$i],
                    'UNIT_PRICE' => $rates[$i],
                    'TOTAL_AMOUNT' => $total_prices[$i],
                    'CREATED_BY' => Auth::id(),
                    'CREATED_ON' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Check if any items were removed from the form for this requisition, and deactivate them in DB
        # prevItemsIds has item IDs connected to the requisition before update
        foreach ($prevItemIds as $prevItemId) {
            if (!in_array($prevItemId, $itemIds)) {
                // In case the item ID in table is not in form submitted data, item has been removed, deactivate it in table
                DB::table('maintenance_req_items')->where('ITEM_ID', $prevItemId)
                    ->update([
                        'IS_ACTIVE' => 'N',
                        'MODIFIED_BY' => Auth::id(),
                        'MODIFIED_ON' => date('Y-m-d H:i:s')
                    ]);
            }
        }

        // To upload scanned copy of invoice if updated invoice is provided
        if ($request->hasFile('mainten_invoice')) {
            $invoice = $request->file('mainten_invoice');
            $document = time() . '-' . date('Y') . '.' . $invoice->getClientOriginalExtension();
            $destination = public_path('/upload/documents/maintenance/');
            $invoice->move($destination, $document);

            // Change filename in DB column:

        }

        // Return to Maintenance Requisitions Listing if update successful
        return redirect()->route('maintenance-requisitions')->with('message', "Requisition details successfully updated");
    }

    /**
     * Deactivate / Activate Requisition
     */
    public function changeActivationStatus(Request $request)
    {
        # Uncomment code below if Activate / De-activate feature is required
        // $mainten_req_id = $request->mainten_req_id;
        // $maintenRequisition = MaintenanceRequisition::find($mainten_req_id);

        // $currentStatus = $maintenRequisition->IS_ACTIVE;
        // $maintenRequisition->IS_ACTIVE = $currentStatus == 'Y' ? 'N' : 'Y';
        // $maintenRequisition->MODIFIED_BY = Auth::id();
        // // Save changes
        // return response($maintenRequisition, 200);
    }

    /**
     * Change Approval Status of the Requisition
     */
    public function approvalStatusUpdate(Request $request)
    {
        $mainten_req_id = $request->mainten_req_id;
        $maintenRequisition = MaintenanceRequisition::find($mainten_req_id); // Find by Id
        // Change status based on flag value in request
        // status = 1 => Approved, status = 2 => Rejected

        $message = '';
        if ($request->approval_status == 1) {
            $maintenRequisition->APPROVAL_STATUS = 'A';
            $maintenRequisition->APPROVED_BY = Auth::id();
            $maintenRequisition->APPROVED_ON = date('Y-m-d H:i:s');
            $message = "Successfully approved";
        } else if ($request->approval_status == 2) {
            $maintenRequisition->APPROVAL_STATUS = 'R';
            $maintenRequisition->APPROVED_BY = Auth::id();
            $maintenRequisition->APPROVED_ON = date('Y-m-d H:i:s');
            $message = 'Requisition rejected';
        } else {
            $maintenRequisition->APPROVAL_STATUS = 'P';
        }


        $maintenRequisition->MODIFIED_BY = Auth::id();
        // Save changes
        $statusUpdated = $maintenRequisition->save();

        if ($statusUpdated)
            return response()->json(['successCode' => 1, 'message' => $message]);
        else
            return response()->json(['successCode' => 0, 'message' => "Failed to update requisition status"]);
    }

    /**
     * Return listing of all Maintenance Requistion Approval Authorities
     */
    public function approvalAuthorities(Request $request)
    {
        if (request()->isMethod('post')) {
            // Return JSON list of all approval authorities
            $filter_dept = $request->dept_sr;
            $filter_status = $request->req_phasesr;
            $req_typesr = 2; // For Maintenance Requisition

            $approvalAuthData = DB::table('mstr_approval_authorities')
                ->join('mstr_requisition_types', 'mstr_approval_authorities.REQUISITION_TYPE', '=', 'mstr_requisition_types.REQUISITION_TYPE_ID')
                ->join('mstr_phases', 'mstr_approval_authorities.REQUISITION_PHASE', '=', 'mstr_phases.PHASE_ID')
                ->select(
                    'mstr_approval_authorities.*',
                    'mstr_requisition_types.REQUISITION_TYPE_NAME as REQ_TYPE_NAME',
                    'mstr_phases.PHASE_NAME as PHASE_NAME'
                )
                ->where('REQUISITION_TYPE', $req_typesr)
                ->when($filter_dept, function ($query, $filter_dept) {
                    return $query->where('DEPARTMENT_CODE', '=', $filter_dept);
                })
                ->when($filter_status, function ($query, $filter_status) {
                    return $query->where('REQUISITION_PHASE', '=', $filter_status);
                })
                ->get();

            return $approvalAuthData->toJson();
        } else {
            $reqTypes = RequisitionType::where('IS_ACTIVE', 'Y')->get();
            $phases = Phase::where('IS_ACTIVE', 'Y')->get();

            // To get departments and employees
            $hrApi = new HrApi;
            $departments = $hrApi->getDepartments();
            $employees = $hrApi->getEmployeeList(""); //Dept "" to get all employees

            return view('maintenance.maintenance-approval-authorities', compact('reqTypes', 'departments', 'employees', 'phases'));
        }
    }

    /**
     * Load Employees to Add/Edit Approval Authority when department is selected/changed
     */
    public function getEmployeeData(Request $request)
    {
        $dept = $request->department;

        if ($dept == "" || $dept == null)
            return;
        $deptArray = explode('|', $dept); # Since option values are in form: deptCode|deptName
        // dd($deptArray);
        $data = new stdClass;
        $data->department = $deptArray[1]; # Send deptName to API method to get employee list
        $hrApi = new HrApi;

        $employeeData = $hrApi->getEmployeeList($data);
        return $employeeData;
    }

    /**
     * Load all employees data to <select> field when adding/updating approval authority
     */
    public function getAllEmployeeData(Request $request)
    {
        $hrApi = new HrApi;
        $employeeData = $hrApi->getEmployeeList("");  // Dept Name is "" to get all employees' data
        return $employeeData;
    }

    /**
     * Add Maintenance Requsition Approval Authority
     */
    public function addApprovalAuthority(Request $request)
    {
        $maintenReqApprovalAuthority = new ApprovalAuthority;

        // To get Dept and Employee Details which are in form id|value
        // e.g. Dept option value is in format deptCode|deptName to enable storing both details in DB
        $deptString = $request->department;
        $employeeString = $request->employee;
        $deptData = explode('|', $deptString);
        $deptCode = $deptData[0];
        $deptName = $deptData[1];
        $employeeData = explode('|', $employeeString);
        $employeeId = $employeeData[0];
        $employeeName = $employeeData[1];

        // Add Details
        $maintenReqApprovalAuthority->REQUISITION_TYPE = $request->req_type;
        $maintenReqApprovalAuthority->REQUISITION_PHASE = $request->phase;
        $maintenReqApprovalAuthority->DEPARTMENT_CODE = $deptCode;
        $maintenReqApprovalAuthority->DEPARTMENT_NAME = $deptName;
        $maintenReqApprovalAuthority->EMPLOYEE_ID = $employeeId;
        $maintenReqApprovalAuthority->EMPLOYEE_NAME = $employeeName;
        $maintenReqApprovalAuthority->CREATED_BY = Auth::id();
        $added = $maintenReqApprovalAuthority->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Approval authority successfully added']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add approval authority']);
        }
    }

    /**
     * Update Maintenance Approval Authority Details
     */
    public function updateApprovalAuthority(Request $request)
    {
        $authority_id = $request->auth_id;
        $maintenReqApprovalAuthority = ApprovalAuthority::find($authority_id);
        $maintenReqApprovalAuthority->REQUISITION_PHASE = $request->phase;

        $deptString = $request->department;
        $deptData = explode('|', $deptString);
        $deptCode = $deptData[0];
        $deptName = $deptData[1];

        # Employee (approver) is not currently changeable

        $maintenReqApprovalAuthority->DEPARTMENT_CODE = $deptCode;
        $maintenReqApprovalAuthority->DEPARTMENT_NAME = $deptName;
        $maintenReqApprovalAuthority->MODIFIED_BY = Auth::id();
        $updated = $maintenReqApprovalAuthority->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Approval authority successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update approval authority']);
        }
    }

    /**
     * Activate / De-activate Approval Authority
     */
    public function changeActivationOfApprovalAuthority(Request $request)
    {
        $authority_id = $request->req_auth_id;
        $status = $request->req_status == 1 ? 'Y' : 'N';

        $maintenReqApprovalAuthority = ApprovalAuthority::find($authority_id);
        $maintenReqApprovalAuthority->IS_ACTIVE = $status;
        $maintenReqApprovalAuthority->MODIFIED_BY = Auth::id();
        $activationUpdated = $maintenReqApprovalAuthority->save();

        if ($activationUpdated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
        }
    }
}
