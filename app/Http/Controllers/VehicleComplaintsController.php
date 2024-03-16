<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleComplaint;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleComplaintsController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // For table listing and filtering
            $filter_date_fr = $request->filter_date_from;
            $filter_date_to = $request->filter_date_to;
            $vehicle = $request->filter_vehicle;

            $date_from = null;
            $date_to = null;

            # To convert date times to required format as in DB (YYYY-MM-DD)
            if (isset($filter_date_fr))
                $date_from = date('Y-m-d', strtotime($filter_date_fr));
            if (isset($filter_date_to))
                $date_to = date('Y-m-d', strtotime($filter_date_to));

            $complaintsList = DB::table('complaints')
                ->join('vehicles', 'complaints.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
                ->join('mstr_vehicle_type', 'complaints.VEHICLE_TYPE_ID', '=', 'mstr_vehicle_type.VEHICLE_TYPE_ID')
                ->join('drivers', 'complaints.DRIVER_ID', '=', 'drivers.DRIVER_ID')
                ->select('complaints.*', 'vehicles.VEHICLE_NAME', 'vehicles.LICENSE_PLATE', 'mstr_vehicle_type.VEHICLE_TYPE_NAME as VEHICLE_TYPE', 'drivers.DRIVER_NAME')
                ->when($vehicle, function ($query, $vehicle) {
                    return $query->where('complaints.VEHICLE_ID', '=', $vehicle);
                })
                ->when($date_from, function ($query, $date_from) {
                    return $query->where('complaints.DATE', '>=', $date_from);
                })
                ->when($date_to, function ($query, $date_to) {
                    return $query->where('complaints.DATE', '>=', $date_to);
                })
                ->get();

            return $complaintsList->toJson();
        } else {
            // To return the index view with master data
            $drivers = Driver::where('IS_ACTIVE', 'Y')->get();
            $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
            $vehicleTypes = VehicleType::where('IS_ACTIVE', 'Y')->get();
            return view('maintenance.complaints', compact('drivers', 'vehicles', 'vehicleTypes'));
        }
    }

    public function getFilteredVehicles(Request $request)
    {
        $vehicleType = $request->vehicle_type;
        $vehicleList = Vehicle::where('VEHICLE_TYPE_ID', $vehicleType)->where('IS_ACTIVE', 'Y')->get();
        return $vehicleList->toJson();
    }

    public function add(Request $request)
    {
        $complaint = new VehicleComplaint;
        $complaint->COMPLAINT_REGISTER = $request->complaint_register;
        $complaint->COMPLAINT_DATE = date('Y-m-d', strtotime($request->complaint_date));
        $complaint->VEHICLE_TYPE_ID = $request->complaint_vehicle_type;
        $complaint->VEHICLE_ID = $request->complaint_vehicle;
        if (isset($request->job_card_number))
            $complaint->JOB_CARD_NUMBER = $request->job_card_number;
        $complaint->MODEL = $request->complaint_vehicle_model ?? '';
        if (isset($request->km_reading))
            $complaint->ODOMETER_READING = $request->km_reading;
        $complaint->DRIVER_ID = $request->driver;
        $complaint->REPAIR_DETAILS = $request->repair_details;
        $complaint->REPAIR_START_DATE = date('Y-m-d', strtotime($request->repair_start_date));
        if (isset($request->repair_completion_date))
            $complaint->REPAIR_COMPLETION_DATE = date('Y-m-d', strtotime($request->repair_completion_date));
        if (isset($request->bill_amount))
            $complaint->BILL_AMOUNT = $request->bill_amount;

        $complaint->CREATED_BY = Auth::id();
        $added = $complaint->save();
        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Complaint successfully logged']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to log complaint']);
        }
    }

    // Get details to show in Edit Form
    public function getDetails(Request $request)
    {
        $complaintId = $request->complaint_id;
        $complaint = VehicleComplaint::find($complaintId);
        return $complaint->toJson();
    }

    // get details to show in View Info
    public function getDetailsToView(Request $request)
    {
        $complaintId = $request->complaint_id;
        $complaintDetails = DB::table('complaints')
            ->join('vehicles', 'complaints.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->join('mstr_vehicle_type', 'complaints.VEHICLE_TYPE_ID', '=', 'mstr_vehicle_type.VEHICLE_TYPE_ID')
            ->join('drivers', 'complaints.DRIVER_ID', '=', 'drivers.DRIVER_ID')
            ->where('COMPLAINT_ID', $complaintId)
            ->select('complaints.*', 'vehicles.VEHICLE_NAME', 'vehicles.LICENSE_PLATE', 'mstr_vehicle_type.VEHICLE_TYPE_NAME', 'drivers.DRIVER_NAME')
            ->get();

        return $complaintDetails->toJson();
    }

    public function update(Request $request)
    {
        $complaintId = $request->complaint_id;
        $complaint = VehicleComplaint::find($complaintId);

        $complaint->COMPLAINT_REGISTER = $request->complaint_register;
        $complaint->COMPLAINT_DATE = date('Y-m-d', strtotime($request->complaint_date));
        $complaint->VEHICLE_TYPE_ID = $request->complaint_vehicle_type;
        $complaint->VEHICLE_ID = $request->complaint_vehicle;
        if (isset($request->job_card_number))
            $complaint->JOB_CARD_NUMBER = $request->job_card_number;
        $complaint->MODEL = $request->complaint_vehicle_model ?? '';
        if (isset($request->km_reading))
            $complaint->ODOMETER_READING = $request->km_reading;
        $complaint->DRIVER_ID = $request->driver;
        $complaint->REPAIR_DETAILS = $request->repair_details;
        $complaint->REPAIR_START_DATE = date('Y-m-d', strtotime($request->repair_start_date));
        if (isset($request->repair_completion_date))
            $complaint->REPAIR_COMPLETION_DATE = date('Y-m-d', strtotime($request->repair_completion_date));
        if (isset($request->bill_amount))
            $complaint->BILL_AMOUNT = $request->bill_amount;

        $complaint->MODIFIED_BY = Auth::id();
        $updated = $complaint->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update complaint']);
        }
    }

    public function updateApprovalStatus(Request $request)
    {
        $complaintId = $request->complaint_id;
        $approval_status_flag = $request->approval_status;
        $approval_status = $approval_status_flag == 'A' ? 'A' : 'X';
        $vehicleComplaint = VehicleComplaint::find($complaintId);

        $vehicleComplaint->APPROVAL_STATUS = $approval_status;
        $vehicleComplaint->MODIFIED_BY = Auth::id();

        $approvalStatusUpdated = $vehicleComplaint->save();
        if ($approvalStatusUpdated) {
            return response()->json(['successCode' => 1, 'message' => 'Approval status successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update approval']);
        }
    }

    public function updateCompletionStatus(Request $request)
    {
        $complaintId = $request->complaint_id;
        $vehicleComplaint = VehicleComplaint::find($complaintId);
        $vehicleComplaint->REPAIR_COMPLETION_DATE = date('Y-m-d', strtotime($request->repair_completion_date));
        $vehicleComplaint->BILL_AMOUNT = $request->bill_amount;
        $vehicleComplaint->APPROVAL_STATUS = 'C';

        $completed = $vehicleComplaint->save();
        if ($completed)
            return response()->json(['successCode' => 1, 'message' => 'Complaint has been successfully closed']);
        else
            return response()->json(['successCode' => 1, 'message' => 'Complaint could not be marked as completed']);
    }
}
