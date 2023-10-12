<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Driver;
use App\Models\HrApi;
use App\Models\Ownership;
use App\Models\RTACircleOffice;
use App\Models\Vehicle;
use App\Models\VehicleDivision;
use App\Models\VehicleType;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class VehicleController extends Controller
{
    public function index()
    {
        $hrApi = new HrApi;
        $departments = $hrApi->getDepartments();
        $trusts = $hrApi->getTrusts();
        $deptData = $departments['data'];
        $trustData = $trusts['data'];

        return view('vehicle.vehicle-list')
            ->with('departments', $deptData)
            ->with('trusts', $trustData)
            ->withOwnerships(Ownership::get())
            ->withVehicleTypes(VehicleType::get())
            ->withDivisions(VehicleDivision::get())
            ->withRtaOffices(RTACircleOffice::get())
            ->withVendors(Vendor::get())
            ->withDrivers(Driver::get());
    }

    public function getAllVehicleDetails(Request $request)
    {
        $dept = $request->search_department;
        $vehicle_type = $request->vehicle_typesr;
        $ownership = $request->ownershipsr;
        $registration_date_from = $request->registration_date_fr;
        $reg_date_from = null;
        # To convert date from 01-Jan-2023 format to 2023-01-01 format for storing in DB:
        if ($registration_date_from)
            $reg_date_from = date('Y-m-d', strtotime($registration_date_from));

        $registration_date_to = $request->registration_date_to;
        $reg_date_to = null;
        if ($registration_date_to)
            $reg_date_to = date('Y-m-d', strtotime($registration_date_to));
        $vendor = $request->vendorsr;

        $vehicles = DB::table('vehicles')
            ->join('mstr_vehicle_type', 'vehicles.VEHICLE_TYPE_ID', '=', 'mstr_vehicle_type.VEHICLE_TYPE_ID')
            ->join('mstr_vehicle_division', 'vehicles.VEHICLE_DIVISION_ID', '=', 'mstr_vehicle_division.VEHICLE_DIVISION_ID')
            ->join('mstr_rta_circle_office', 'vehicles.RTA_CIRCLE_OFFICE_ID', '=', 'mstr_rta_circle_office.RTA_CIRCLE_OFFICE_ID')
            ->leftJoin('drivers', 'vehicles.DRIVER_ID', '=', 'drivers.DRIVER_ID')
            ->join('mstr_vendor', 'vehicles.VENDOR_ID', '=', 'mstr_vendor.VENDOR_ID')
            // ->join('mstr_ownership', 'vehicles.OWNERSHIP_ID', '=', 'mstr_ownership.OWNERSHIP_ID')
            ->select(
                'vehicles.VEHICLE_ID',
                'vehicles.VEHICLE_NAME',
                'mstr_vehicle_type.VEHICLE_TYPE_NAME',
                'vehicles.DEPARTMENT_ID',
                'vehicles.DEPARTMENT_NAME',
                'vehicles.REGISTRATION_DATE',
                'mstr_vehicle_division.VEHICLE_DIVISION_NAME',
                'mstr_rta_circle_office.RTA_CIRCLE_OFFICE_NAME',
                'vehicles.DRIVER_ID',
                'vehicles.OWNERSHIP_ID',
                'vehicles.OWNERSHIP_NAME',
                'drivers.DRIVER_NAME',
                'mstr_vendor.VENDOR_NAME',
                // 'mstr_ownership.OWNERSHIP_NAME',
                'vehicles.IS_ACTIVE'
            )
            // ->where('vehicles.IS_ACTIVE', '=', 'Y')
            ->when($dept, function ($query, $dept) {
                return $query->where('vehicles.DEPARTMENT_ID', '=', $dept);
            })
            ->when($vehicle_type, function ($query, $vehicle_type) {
                return $query->where('vehicles.VEHICLE_TYPE_ID', '=', $vehicle_type);
            })
            ->when($ownership, function ($query, $ownership) {
                return $query->where('vehicles.OWNERSHIP_ID', '=', $ownership);
            })
            ->when($reg_date_from, function ($query, $reg_date_from) {
                return $query->where('vehicles.REGISTRATION_DATE', '>', $reg_date_from);
            })
            ->when($reg_date_to, function ($query, $reg_date_to) {
                return $query->where('vehicles.REGISTRATION_DATE', '<', $reg_date_to);
            })
            ->when($vendor, function ($query, $vendor) {
                return $query->where('vehicles.VENDOR_ID', '=', $vendor);
            })
            ->get();

        $vehicleDetails = $vehicles->toJson();
        echo $vehicleDetails;
    }

    /**
     * Store a newly created Vehicle resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = new Vehicle;

        $vehicle->VEHICLE_NAME = $request->vehicle_name;
        $vehicle->VEHICLE_TYPE_ID = $request->vehicle_type;

        $department = $request->department;
        # Input 'department' is in form: deptCode|deptName as option value in select
        $deptArray = explode('|', $department);
        $vehicle->DEPARTMENT_ID = $deptArray[0];  # deptCode
        $vehicle->DEPARTMENT_NAME = $deptArray[1]; # deptName

        $vehicle->VEHICLE_DIVISION_ID = $request->vehicle_division;
        $vehicle->REGISTRATION_DATE = date('Y-m-d', strtotime($request->registration_date));
        $vehicle->RTA_CIRCLE_OFFICE_ID = $request->rta_office;
        $vehicle->LICENSE_PLATE = $request->license_plate;
        $vehicle->DRIVER_ID = $request->driver ?? 0;
        $vehicle->ALERT_CELL_NUMBER = $request->alert_cell_no;
        $vehicle->VENDOR_ID = $request->vendor;
        $vehicle->ALERT_EMAIL_ID = $request->alert_email;
        $vehicle->SEAT_CAPACITY = $request->seat_capacity;

        // Details added Oct 3 2023
        $vehicle->CHASSIS_NUMBER = $request->chassis_number;
        $vehicle->ENGINE_NUMBER = $request->engine_number;
        $vehicle->VEHICLE_VALUE = $request->vehicle_value;
        $vehicle->UVW = $request->uvw ?? 0;
        $vehicle->CC = $request->cc ?? 0;

        $ownership = $request->ownership;
        $ownershipArray = explode('|', $ownership);
        $vehicle->OWNERSHIP_ID = $ownershipArray[0];
        $vehicle->OWNERSHIP_NAME = $ownershipArray[1];
        $vehicle->EMPLOYEE_ID = '';
        $vehicle->EMPLOYEE_NAME = '';
        $vehicle->CREATED_BY = Auth::user()->USER_ID;

        $added = $vehicle->save();
        if ($added) {
            return response()->json([
                'successCode' => 1,
                'message' => 'Vehicle details added successfully'
            ]);
        } else {
            return response()->json([
                'successCode' => 0,
                'message' => 'Could not add vehicle details'
            ]);
        }
    }

    /**
     * Get vehicle details for specified vehicle ID
     */
    public function getDetails(Request $request)
    {
        $vehicleId = $request->vehicle_id;
        $vehicle = Vehicle::find($vehicleId);
        if ($vehicle)
            return response()->json(['successCode' => 1, 'data' => $vehicle]);
        else
            return response()->json(['successCode' => 0]);
    }


    /**
     * Update the specified Vehicle resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->VEHICLE_NAME = $request->vehicle_name;
        $vehicle->VEHICLE_TYPE_ID = $request->vehicle_type;

        $department = $request->department;
        # Input 'department' is in form: deptCode|deptName as option value in select
        $deptArray = explode('|', $department);
        $vehicle->DEPARTMENT_ID = $deptArray[0];  #deptCode
        $vehicle->DEPARTMENT_NAME = $deptArray[1]; #deptName

        // Date Format: Y-m-d in php

        $vehicle->VEHICLE_DIVISION_ID = $request->vehicle_division;
        $vehicle->REGISTRATION_DATE = date('Y-m-d', strtotime($request->registration_date));
        $vehicle->RTA_CIRCLE_OFFICE_ID = $request->rta_office;
        $vehicle->LICENSE_PLATE = $request->license_plate;
        // $vehicle->DRIVER_ID = $request->driver;
        $vehicle->ALERT_CELL_NUMBER = $request->alert_cell_no;
        $vehicle->VENDOR_ID = $request->vendor;
        $vehicle->ALERT_EMAIL_ID = $request->alert_email;
        $vehicle->SEAT_CAPACITY = $request->seat_capacity;

        $ownership = $request->ownership;
        $ownershipArray = explode('|', $ownership);
        $vehicle->OWNERSHIP_ID = $ownershipArray[0];  # Trust Code
        $vehicle->OWNERSHIP_NAME = $ownershipArray[1]; # Name of the Trust

        // Details added Oct 3 2023
        $vehicle->CHASSIS_NUMBER = $request->chassis_number;
        $vehicle->ENGINE_NUMBER = $request->engine_number;
        $vehicle->VEHICLE_VALUE = $request->vehicle_value;
        $vehicle->UVW = $request->uvw ?? 0;
        $vehicle->CC = $request->cc ?? 0;

        // $vehicle->IS_ACTIVE = 'Y';
        $vehicle->MODIFIED_BY = Auth::user()->USER_ID;

        $updated = $vehicle->save();
        if ($updated) {
            return response()->json([
                'successCode' => 1,
                'message' => 'Vehicle details updated successfully'
            ]);
        } else {
            return response()->json([
                'successCode' => 0,
                'message' => 'Could not update vehicle details'
            ]);
        }
    }

    /**
     * Activate or Deactivate Vehicle
     */
    // Activate/ de-activate vendor in DB
    public function statusUpdate(Request $request)
    {
        $vehicleId = $request->vehicle_id;
        $vehicle = Vehicle::find($vehicleId);

        if ($vehicle->IS_ACTIVE == 'Y')
            $vehicle->IS_ACTIVE = 'N';
        else
            $vehicle->IS_ACTIVE = 'Y';

        $vehicle->MODIFIED_BY = Auth::user()->USER_ID;
        $vehicle->save();

        return response($vehicle, 200);
    }

    /**
     * Assign the vehicle to a specified driver
     */
    public function assignVehicleToDriver(Request $request)
    {
        $driver_id = $request->vehicle_driver;
        $vehicle_id = $request->vehicle_id;

        $vehicle = Vehicle::find($vehicle_id);
        $vehicle->DRIVER_ID = $driver_id;
        $vehicle->MODIFIED_BY = Auth::id();
        $driverAssigned = $vehicle->save();
        if ($driverAssigned) {
            return response()->json(['successCode' => 1, 'message' => "Vehicle successfully allocated to driver"]);
        } else {
            return response()->json(['successCode' => 0, 'message' => "Failed to assign driver"]);
        }
    }

    /**
     * Get Employees to Allocate Vehicle Form when Department is selected / changed
     */
    public function getEmployees(Request $request)
    {
        $dept = $request->department;

        if ($dept == "")
            return [];
        else {
            $data = new stdClass;
            $deptArray = explode('|', $dept); # Since option values are in form: deptCode|deptName
            $data->department = $deptArray[1];
            $hrApi = new HrApi;
            $employeeData = $hrApi->getEmployeeList($data);
            return $employeeData;
        }
    }


    /**
     * Allocate vehicle to Employee
     */
    public function allocateVehicle(Request $request)
    {
        $vehicle_id = $request->vehicle_id;

        $dept = $request->vehicle_dept;
        $owner = $request->vehicle_owner;

        $departmentArray = explode('|', $dept);
        $ownerArray = explode('|', $owner);

        $vehicle = Vehicle::find($vehicle_id);
        $vehicle->DEPARTMENT_ID = $departmentArray[0];
        $vehicle->DEPARTMENT_NAME = $departmentArray[1];
        $vehicle->EMPLOYEE_ID = $ownerArray[0];
        $vehicle->EMPLOYEE_NAME = $ownerArray[1];

        $vehicle->MODIFIED_BY = Auth::id();

        $vehicleAllocated = $vehicle->save();
        if ($vehicleAllocated)
            return response()->json(['successCode' => 1, 'message' => 'Successfully allocated vehicle to employee']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to allocate vehicle to employee']);
    }
}
