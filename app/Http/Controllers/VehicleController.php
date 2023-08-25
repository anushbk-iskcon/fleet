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
        $registration_date_to = $request->registration_date_to;
        $vendor = $request->vendorsr;

        $vehicles = DB::table('vehicles')
            ->join('mstr_vehicle_type', 'vehicles.VEHICLE_TYPE_ID', '=', 'mstr_vehicle_type.VEHICLE_TYPE_ID')
            ->join('mstr_department', 'vehicles.DEPARTMENT_ID', '=', 'mstr_department.DEPARTMENT_ID')
            ->join('mstr_vehicle_division', 'vehicles.VEHICLE_DIVISION_ID', '=', 'mstr_vehicle_division.VEHICLE_DIVISION_ID')
            ->join('mstr_rta_circle_office', 'vehicles.RTA_CIRCLE_OFFICE_ID', '=', 'mstr_rta_circle_office.RTA_CIRCLE_OFFICE_ID')
            ->join('drivers', 'vehicles.DRIVER_ID', '=', 'drivers.DRIVER_ID')
            ->join('mstr_vendor', 'vehicles.VENDOR_ID', '=', 'mstr_vendor.VENDOR_ID')
            ->join('mstr_ownership', 'vehicles.OWNERSHIP_ID', '=', 'mstr_ownership.OWNERSHIP_ID')
            ->select(
                'vehicles.VEHICLE_ID',
                'vehicles.VEHICLE_NAME',
                'mstr_vehicle_type.VEHICLE_TYPE_NAME',
                'mstr_department.DEPARTMENT_NAME',
                'vehicles.REGISTRATION_DATE',
                'mstr_vehicle_division.VEHICLE_DIVISION_NAME',
                'mstr_rta_circle_office.RTA_CIRCLE_OFFICE_NAME',
                'drivers.DRIVER_NAME',
                'mstr_vendor.VENDOR_NAME',
                'mstr_ownership.OWNERSHIP_NAME',
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
            ->when($registration_date_from, function ($query, $registration_date_from) {
                return $query->where('vehicles.REGISTRATION_DATE', '>', $registration_date_from);
            })
            ->when($registration_date_to, function ($query, $registration_date_to) {
                return $query->where('vehicles.REGISTRATION_DATE', '<', $registration_date_to);
            })
            ->when($vendor, function ($query, $vendor) {
                return $query->where('vehicles.VENDOR_ID', '=', $vendor);
            })
            ->get();

        $testVehicles = $vehicles->toJson();
        echo $testVehicles;
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
        $vehicle->DEPARTMENT_ID = $request->department;
        # Add Dept Name from Request below:

        $vehicle->VEHICLE_DIVISION_ID = $request->vehicle_division;
        $vehicle->REGISTRATION_DATE = $request->registration_date;
        $vehicle->RTA_CIRCLE_OFFICE_ID = $request->rta_office;
        $vehicle->LICENSE_PLATE = $request->license_plate;
        $vehicle->DRIVER_ID = $request->driver;
        $vehicle->ALERT_CELL_NUMBER = $request->alert_cell_no;
        $vehicle->VENDOR_ID = $request->vendor;
        $vehicle->ALERT_EMAIL_ID = $request->alert_email;
        $vehicle->SEAT_CAPACITY = $request->seat_capacity;
        $vehicle->OWNERSHIP_ID = $request->ownership;
        // $vehicle->IS_ACTIVE = 'Y';
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
        $vehicle->DEPARTMENT_ID = $request->department;
        # update dept Name
        $vehicle->VEHICLE_DIVISION_ID = $request->vehicle_division;
        $vehicle->REGISTRATION_DATE = $request->registration_date;
        $vehicle->RTA_CIRCLE_OFFICE_ID = $request->rta_office;
        $vehicle->LICENSE_PLATE = $request->license_plate;
        $vehicle->DRIVER_ID = $request->driver;
        $vehicle->ALERT_CELL_NUMBER = $request->alert_cell_no;
        $vehicle->VENDOR_ID = $request->vendor;
        $vehicle->ALERT_EMAIL_ID = $request->alert_email;
        $vehicle->SEAT_CAPACITY = $request->seat_capacity;
        $vehicle->OWNERSHIP_ID = $request->ownership;
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
}
