<?php

namespace App\Http\Controllers;

use App\Models\ApprovalAuthority;
use App\Models\RefuelRequisition;
use App\Models\Fuel;
use App\Models\FuelStation;
use App\Models\HrApi;
use App\Models\Phase;
use App\Models\RequisitionType;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefuelRequisitionController extends Controller
{
    //
    /**
     * Return page listing all refueling requests
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        $fuelTypes = Fuel::all();
        $fuelStations = FuelStation::all();
        return view('refueling.refuel-requisitions', compact('fuelTypes', 'fuelStations', 'vehicles'));
    }

    /**
     * Return Details of Refuel Requisition
     */
    public function getDetails(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        if ($refuelRequest)
            return response()->json(['successCode' => 1, 'data' => $refuelRequest]);
        else
            return response()->json(['successCode' => 0, 'message' => 'No data found']);
    }

    /**
     * Return JSON Response listing all or filtered Requisitions, for drawing/re-drawing table
     */
    public function list(Request $request)
    {
        // Filters if applied

        // Data filtered if any of the values above are present
        $reqList = DB::table('refueling_requisition')
            ->join('vehicles', 'refueling_requisition.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->join('mstr_fuel', 'refueling_requisition.FUEL_TYPE', '=', 'mstr_fuel.FUEL_ID')
            ->join('mstr_fuel_station', 'refueling_requisition.FUEL_STATION', '=', 'mstr_fuel_station.FUEL_STATION_ID')
            ->select(
                'refueling_requisition.REFUEL_REQUISITION_ID as REFUEL_REQUISITION_ID',
                'vehicles.VEHICLE_NAME as VEHICLE_NAME',
                'mstr_fuel.FUEL_TYPE_NAME as FUEL_TYPE',
                'refueling_requisition.QUANTITY as QUANTITY',
                'refueling_requisition.CURRENT_ODOMETER as CURRENT_ODOMETER',
                'mstr_fuel_station.FUEL_STATION_NAME as FUEL_STATION',
                'refueling_requisition.AMOUNT as AMOUNT',
                'refueling_requisition.STATUS as STATUS',
                'refueling_requisition.IS_ACTIVE as IS_ACTIVE'
            )
            ->get();
        return $reqList->toJson();
    }

    /**
     * Add new refueling requisition to DB
     */
    public function store(Request $request)
    {
        $refuelRequest = new RefuelRequisition;
        $refuelRequest->VEHICLE_ID = $request->vehicle_name;
        $refuelRequest->FUEL_TYPE = $request->fuel_type;
        $refuelRequest->QUANTITY = $request->qty;
        $refuelRequest->CURRENT_ODOMETER = $request->current_odometer;
        $refuelRequest->FUEL_STATION = $request->fuel_station;
        $refuelRequest->AMOUNT = $request->amount;
        $refuelRequest->STATUS = 'P';
        $refuelRequest->CREATED_BY = Auth::id();
        $added = $refuelRequest->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Refuel requisition added successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add requisition']);
        }
    }

    /**
     * Update Refuel Requisition Details in DB
     */
    public function update(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        $refuelRequest->VEHICLE_ID = $request->vehicle_name;
        $refuelRequest->FUEL_TYPE = $request->fuel_type;
        $refuelRequest->QUANTITY = $request->qty;
        $refuelRequest->CURRENT_ODOMETER = $request->current_odometer;

        // Check if Requisition is Pending and update amount if present
        if ($refuelRequest->STATUS == 'P') {
            if (isset($request->amount)) {
                $refuelRequest->AMOUNT = $request->amount;
            }
        }

        $refuelRequest->FUEL_STATION = $request->fuel_station;
        $refuelRequest->MODIFIED_BY = Auth::id();
        $modified = $refuelRequest->save();

        if ($modified) {
            return response()->json(['successCode' => 1, 'message' => 'Changes successfully saved']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to make changes']);
        }
    }

    /**
     * Activate / Deactivate Refuel Requisition
     */
    public function changeActivationStatus(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        if ($refuelRequest->IS_ACTIVE === 'Y')
            $refuelRequest->IS_ACTIVE = 'N';
        else
            $refuelRequest->IS_ACTIVE = 'Y';

        $refuelRequest->MODIFIED_BY = Auth::id();
        $refuelRequest->save();
        return response($refuelRequest, 200);
    }

    /**
     * Change status (pending/approved)
     */
    public function changeStatus(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        $requisition_status = $request->requisition_status;
        if ($requisition_status == '0') // Pending
            $refuelRequest->STATUS = 'P';
        else if ($requisition_status == '1') // Released
            $refuelRequest->STATUS = 'R';
        else                                 // Default
            $refuelRequest->STATUS = 'P';

        $refuelRequest->MODIFIED_BY = Auth::id();
        $refuelRequest->save();
        return response($refuelRequest, 200);
    }

    /**
     * Return listing of all Refueling Approval Authorities
     */
    public function approvalAuthorities(Request $request)
    {
        if (request()->isMethod('post')) {
            // Return JSON list of all approval authorities
            $filter_dept = $request->dept_sr;
            $filter_status = $request->req_phasesr;
            $req_typesr = 3; // For Refuel Requisition

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

            // To get Departments and Employees
            $hrApi = new HrApi;
            $departments = $hrApi->getDepartments();
            $employees = $hrApi->getEmployeeList(""); //Dept "" to get all employees

            return view('refueling.refuel-approval-authorities', compact('reqTypes', 'phases', 'departments', 'employees'));
        }
    }

    /**
     * Add New Refueling Approval Authority
     */
    public function addApprovalAuthority(Request $request)
    {
        $refuelApprovalAuthority = new ApprovalAuthority;

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
        $refuelApprovalAuthority->REQUISITION_TYPE = $request->req_type;
        $refuelApprovalAuthority->REQUISITION_PHASE = $request->phase;
        $refuelApprovalAuthority->DEPARTMENT_CODE = $deptCode;
        $refuelApprovalAuthority->DEPARTMENT_NAME = $deptName;
        $refuelApprovalAuthority->EMPLOYEE_ID = $employeeId;
        $refuelApprovalAuthority->EMPLOYEE_NAME = $employeeName;
        $refuelApprovalAuthority->CREATED_BY = Auth::id();
        $added = $refuelApprovalAuthority->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Approval authority successfully added']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add approval authority']);
        }
    }

    /**
     * Update Details of Refueling Approvla Authority
     */
    public function updateApprovalAuthority(Request $request)
    {
        $authority_id = $request->auth_id;
        $refuelReqApprovalAuthority = ApprovalAuthority::find($authority_id);
        $refuelReqApprovalAuthority->REQUISITION_PHASE = $request->phase;

        $deptString = $request->department;
        $deptData = explode('|', $deptString);
        $deptCode = $deptData[0];
        $deptName = $deptData[1];

        # Employee (approver) is not currently changeable

        $refuelReqApprovalAuthority->DEPARTMENT_CODE = $deptCode;
        $refuelReqApprovalAuthority->DEPARTMENT_NAME = $deptName;
        $refuelReqApprovalAuthority->MODIFIED_BY = Auth::id();
        $updated = $refuelReqApprovalAuthority->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Approval authority successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update Approval authority']);
        }
    }

    /**
     * Activate / De-activate Approval Authority
     */
    public function changeActivationOfApprovalAuthority(Request $request)
    {
        $authority_id = $request->req_auth_id;
        $status = $request->req_status == 1 ? 'Y' : 'N';

        $refuelReqApprovalAuthority = ApprovalAuthority::find($authority_id);
        $refuelReqApprovalAuthority->IS_ACTIVE = $status;
        $refuelReqApprovalAuthority->MODIFIED_BY = Auth::id();
        $activationUpdated = $refuelReqApprovalAuthority->save();

        if ($activationUpdated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
        }
    }
}
