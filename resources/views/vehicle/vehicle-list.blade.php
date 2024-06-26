@extends('layouts.main.app')

@section('title', 'Vehicle Management')

@section('css-content')
<style>
    div.error {
        font-size: .8em;
        color: #f66;
    }

    select.error~.select2 .select2-selection {
        border: 1px solid #f99;
    }

    .customloader {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 3px solid #ddd;
        border-top-color: #28a745;
        animation: rotate 1s infinite;
        position: fixed;
        top: 33%;
        right: 42%;
        display: none;
        z-index: 9999;
    }

    #table-loader {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 6px solid #eee;
        border-top-color: #28a745;
        animation: rotate 1s infinite;
        position: absolute;
        right: 50%;
        z-index: 2;
        display: none;
    }

    @keyframes rotate {
        100% {
            rotate: 360deg;
        }
    }
</style>
@endsection

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Management</h1>
<small id="controllerName">Vehicle List</small>
@endsection

@section('content')
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Vehicle</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <form action="{{route('vehicle.add')}}" id="addVehicleForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="vehicle_name" required="" class="form-control" type="text" placeholder="Vehicle Name" id="vehicle_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicleDept" class="col-sm-5 col-form-label">User Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="vehicleDept">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department['deptCode'] . '|' . $department['deptName'] }}">{{ $department['deptName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="registration_date" class="col-sm-5 col-form-label">Registration Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="registration_date" required="" class="form-control new-datepicker" type="text" placeholder="Registration Date" id="registration_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_plate" class="col-sm-5 col-form-label">License Plate <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="license_plate" required="" class="form-control" type="text" placeholder="License Plate" id="license_plate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="al_cell_no" class="col-sm-5 col-form-label">Alert Cell No <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="alert_cell_no" required="" class="form-control" type="number" placeholder="Alert Cell No" id="al_cell_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="al_email" class="col-sm-5 col-form-label">Alert Email <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="alert_email" required="" class="form-control" type="email" placeholder="Alert Email" id="al_email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ownership" class="col-sm-5 col-form-label">Ownership <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select required="" class="form-control basic-single" name="ownership" id="ownership">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($trusts as $ownership)
                                    <option value="{{$ownership['trustCode'] . '|' . $ownership['trustName']}}">{{$ownership['trustName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="chassis_number" class="col-sm-5 col-form-label">Chassis Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="chassis_number" id="chassis_number" placeholder="Chassis Number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="engine_number" class="col-sm-5 col-form-label">Engine Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="engine_number" id="engine_number" placeholder="Engine Number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_value" class="col-sm-5 col-form-label">Vehicle Value <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" id="vehicle_value" name="vehicle_value" placeholder="Vehicle Value (INR)" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_type" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="vehicle_type" id="vehicle_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType['VEHICLE_TYPE_ID']}}"> {{$vehicleType['VEHICLE_TYPE_NAME']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_division" class="col-sm-5 col-form-label">Vehicle Division <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_division" id="vehicle_division">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($divisions as $division)
                                    <option value="{{$division['VEHICLE_DIVISION_ID']}}">{{$division['VEHICLE_DIVISION_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rta_office" class="col-sm-5 col-form-label">RTA Circle Office <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="rta_office" id="rta_office">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($rtaOffices as $RTAOffice)
                                    <option value="{{$RTAOffice['RTA_CIRCLE_OFFICE_ID']}}">{{$RTAOffice['RTA_CIRCLE_OFFICE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vendor" class="col-sm-5 col-form-label">Vendor <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="vendor" id="vendor">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{$vendor['VENDOR_ID']}}"> {{$vendor['VENDOR_NAME']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="seat_capacity" class="col-sm-5 col-form-label">Seat Capacity (With Driver) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="seat_capacity" required="" class="form-control" type="number" placeholder="Seat Capacity (With Driver)" id="seat_capacity">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="uvw" class="col-sm-5 col-form-label">UVW</label>
                            <div class="col-sm-7">
                                <input type="text" name="uvw" id="uvw" placeholder="UVW" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cc" class="col-sm-5 col-form-label">CC</label>
                            <div class="col-sm-7">
                                <input type="text" placeholder="CC" name="cc" id="cc" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cc" class="col-sm-5 col-form-label">Rate per KM (INR)</label>
                            <div class="col-sm-7">
                                <input type="number" placeholder="Rate per KM (INR)" name="rate_per_km" id="ratePerKm" class="form-control">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" id="resetAddVehicleBtn" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing Vehicle Details -->
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Vehicle</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('vehicle.update', 0)}}" id="editVehicleForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="vehicle_id" id="editVehicleId" value="">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="new_vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="vehicle_name" required="" class="form-control" type="text" placeholder="Vehicle Name" id="new_vehicle_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="newVehicleDept" class="col-sm-5 col-form-label">User Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="newVehicleDept">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department['deptCode'] . '|' . $department['deptName'] }}">{{ $department['deptName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_registration_date" class="col-sm-5 col-form-label">Registration Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="registration_date" required="" class="form-control edit-datepicker" type="text" placeholder="Registration Date" id="new_registration_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_license_plate" class="col-sm-5 col-form-label">License Plate <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="license_plate" required="" class="form-control" type="text" placeholder="License Plate" id="new_license_plate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_al_cell_no" class="col-sm-5 col-form-label">Alert Cell No <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="alert_cell_no" required="" class="form-control" type="number" placeholder="Alert Cell No" id="new_al_cell_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_al_email" class="col-sm-5 col-form-label">Alert Email <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="alert_email" required="" class="form-control" type="email" placeholder="Alert Email" id="new_al_email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_ownership" class="col-sm-5 col-form-label">Ownership <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select required="" class="form-control basic-single" name="ownership" id="new_ownership">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($trusts as $ownership)
                                    <option value="{{$ownership['trustCode'] . '|' . $ownership['trustName']}}">{{$ownership['trustName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_chassis_number" class="col-sm-5 col-form-label">Chassis Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="chassis_number" id="new_chassis_number" class="form-control" placeholder="Chassis Number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_engine_number" class="col-sm-5 col-form-label">Engine Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="engine_number" id="new_engine_number" class="form-control" placeholder="Engine Number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_vehicle_value" class="col-sm-5 col-form-label">Vehicle Value <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="vehicle_value" id="new_vehicle_value" class="form-control" placeholder="Vehicle Value (INR)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="new_vehicle_type" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="vehicle_type" id="new_vehicle_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType['VEHICLE_TYPE_ID']}}"> {{$vehicleType['VEHICLE_TYPE_NAME']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_vehicle_division" class="col-sm-5 col-form-label">Vehicle Division <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_division" id="new_vehicle_division">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($divisions as $division)
                                    <option value="{{$division['VEHICLE_DIVISION_ID']}}">{{$division['VEHICLE_DIVISION_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_rta_office" class="col-sm-5 col-form-label">RTA Circle Office <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="rta_office" id="new_rta_office">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($rtaOffices as $RTAOffice)
                                    <option value="{{$RTAOffice['RTA_CIRCLE_OFFICE_ID']}}">{{$RTAOffice['RTA_CIRCLE_OFFICE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_vendor" class="col-sm-5 col-form-label">Vendor <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="vendor" id="new_vendor">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{$vendor['VENDOR_ID']}}"> {{$vendor['VENDOR_NAME']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_seat_capacity" class="col-sm-5 col-form-label">Seat Capacity (With Driver) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="seat_capacity" required="" class="form-control" type="number" placeholder="Seat Capacity (With Driver)" id="new_seat_capacity">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_uvw" class="col-sm-5 col-form-label">UVW</label>
                            <div class="col-sm-7">
                                <input type="text" name="uvw" id="new_uvw" class="form-control" placeholder="UVW">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-5 col-form-label">CC</label>
                            <div class="col-sm-7">
                                <input type="text" name="cc" id="new_cc" class="form-control" placeholder="CC">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-5 col-form-label">Rate per KM (INR)</label>
                            <div class="col-sm-7">
                                <input type="text" name="rate_per_km" id="newRatePerKM" class="form-control" placeholder="Rate per KM (INR)">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" id="resetEditVehicleForm" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- End modal for editing vehicle details-->

<!-- Modal for assigning driver the selected vehicle -->
<div id="assignVehicleToDriverModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Assign Driver</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vehicle.assign-to-driver')}}" id="assignVehicleToDriverForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    {{-- To send Vehicle ID for vehicle assigned to driver --}}
                    <input type="hidden" name="vehicle_id" id="driverAllocationVehicleId" value="">
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="driverAssignedVehicle" class="col-sm-12 col-lg-4 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-8">
                                <input class="form-control" id="driverAssignedVehicle" type="text" name="vehicle" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="vehicleDriver" class="col-sm-12 col-lg-4 col-form-label">Driver <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-8">
                                <select name="vehicle_driver" id="vehicleDriver" class="form-control basic-single" data-init-driver-value="" required>
                                    <option value="" selected>Please Select</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group text-right">
                            <button type="reset" id="resetAssignVehicleToDriverFormBtn" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- End modal to assign a driver the vehicle -->

<!-- Begin Modal to allocate the vehicle to user -->
<div id="allocateVehicleModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Allocate Vehicle to User</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vehicle.allocate')}}" id="allocateVehicleForm" method="post" class="row" accept-charset="utf-8">
                    @csrf
                    {{-- To send Vehicle ID for vehicle assigned to driver --}}
                    <input type="hidden" name="vehicle_id" id="allocatedVehicleId" value="">
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="allocatedVehicle" class="col-sm-12 col-lg-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-7">
                                <input class="form-control" id="allocatedVehicle" type="text" name="vehicle" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="vehicleAllocatedDept" class="col-sm-12 col-lg-5 col-form-label">User Department <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-7">
                                <select name="vehicle_dept" id="vehicleAllocatedDept" class="form-control basic-single" required onchange="getEmployeesByDept(this)">
                                    <option value="" selected>Select User Department</option>
                                    @foreach($departments as $dept)
                                    <option value="{{$dept['deptCode'] . '|' . $dept['deptName']}}">{{$dept['deptName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="vehicleOwner" class="col-sm-12 col-lg-5 col-form-label">Allocate To <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-7">
                                <select name="vehicle_owner" id="vehicleOwner" class="form-control basic-single" data-init-owner-value="" required>
                                    <option value="" selected>Please Select Owner</option>
                                    <!-- @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group text-right">
                            <button type="reset" id="resetAssignVehicleFormBtn" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal to allocate the vehicle to an employee -->


<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Vehicle
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form id="filterVehiclesForm" action="" method="post" class="row">
                    {{-- Form is currently not submitted using jQuery form.serialize, but by sending each filed individually --}}
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="search_department" class="col-sm-4 col-form-label justify-content-start text-left">User Dept </label>
                            <div class="col-sm-8">
                                <select class="form-control basic-single" name="search_department" id="search_department">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department['deptCode'] }}">{{ $department['deptName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="vehicle_typesr" class="col-sm-4 col-form-label justify-content-start text-left">Vehicle Type </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="vehicle_typesr" id="vehicle_typesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType['VEHICLE_TYPE_ID']}}"> {{$vehicleType['VEHICLE_TYPE_NAME']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="ownershipsr" class="col-sm-4 col-form-label justify-content-start text-left">Ownership </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="ownershipsr" id="ownershipsr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($trusts as $ownership)
                                    <option value="{{$ownership['trustCode']}}">{{$ownership['trustName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-5">
                        <div class="form-group row mb-1">
                            <label for="registration_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Registration Date From </label>
                            <div class="col-sm-6">
                                <input name="registration_date_fr" autocomplete="off" class="form-control filter-datepicker" type="text" placeholder="Registration Date From" id="registration_date_fr">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="registration_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Registration Date To </label>
                            <div class="col-sm-6">
                                <input name="registration_date_to" autocomplete="off" class="form-control filter-datepicker" type="text" placeholder="Registration Date To" id="registration_date_to">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="vendorsr" class="col-sm-5 col-form-label justify-content-start text-left">Vendor </label>
                            <div class="col-sm-6">
                                <select class="form-control" name="vendorsr" id="vendorsr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{$vendor['VENDOR_ID']}}"> {{$vendor['VENDOR_NAME']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-3">
                        <div class="form-group row mb-2">
                            <label for="filterIsActive" class="col-sm-4 col-form-label justify-content-start text-left">Status </label>
                            <div class="col-sm-8 text-right">
                                <select name="is_activesr" id="filterIsActive" class="form-control">
                                    <option value="">Select Is Active</option>
                                    <option value="Y" selected>Active</option>
                                    <option value="N">Deactivated</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                                <button type="reset" class="btn btn-inverse" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Vehicle Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="vehicinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Vehicle No.</th>
                                <th>User Department</th>
                                <th>Registration Date</th>
                                <th>Ownership</th>
                                <th>Vendor</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="customloader"></div>
<!-- <script src="{{asset('dist/js/vehicle_list.js')}}"></script> -->
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        let currentYear = moment().year();

        var vehiclesTable = $("#vehicinfo").DataTable({
            paging: true,
            lengthMenu: [5, 10, 15, 20, 25],
            pageLength: 5,
        });

        $("#vehicinfo").css('width', '100%');

        // To enable datepickers for Filter Dates
        $("#registration_date_fr, #registration_date_to").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            autoApply: false,
            minYear: 1901,
            maxDate: moment(currentYear + '-12-31').format('DD-MMM-YYYY'),
            drops: "down",
            locale: {
                format: 'DD-MMM-YYYY'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        });

        $("#registration_date_fr, #registration_date_to").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#registration_date_fr, #registration_date_to").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        populateVehiclesTable(vehiclesTable);

        // To allow validation of select2 selections
        $('#add0 select.basic-single').on('change', function(e) {
            $(this).valid();
        });
        // To allow validation of select2 selections
        $('#edit select.basic-single').on('change', function(e) {
            $(this).valid();
        });

        // On showing Add Vehicle modal, enable datepicker(s)
        $("#add0").on('shown.bs.modal', function() {
            $("#addVehicleForm .new-datepicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                autoApply: false,
                minYear: 1901,
                maxDate: moment(currentYear + '-12-31').format('DD-MMM-YYYY'),
                drops: "down",
                locale: {
                    format: 'DD-MMM-YYYY'
                },
                maxYear: parseInt(moment().format('YYYY'), 10)
            });

            $("#addVehicleForm .new-datepicker").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $("#addVehicleForm .new-datepicker").on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        // On selecting vehicle type in Add Form, set rate
        $("#vehicle_type").change(function() {
            let vehicle_type = $("#vehicle_type").val();
            let ratePerKM = '';
            // The switch case values are select option values. Since they are strings and switch does strict comparison (===),
            // string values are used for each case
            // CURRENTLY: For Auto (1): INR 20 per KM, For Car (2, 3, 4, 5, 8): INR 25 per KM
            switch (vehicle_type) {
                case '1':
                    ratePerKM = 20;
                    break;
                case '2':
                case '3':
                case '4':
                case '5':
                case '8':
                    ratePerKM = 25;
                    break;
                default:
                    ratePerKM = '';
            }

            $("#ratePerKm").val(ratePerKM);
            // if ($("#vehicle_type").val() == 1)
            //     $("#ratePerKm").val(20);

            // else if ($("#vehicle_type").val() == 2 || $("#vehicle_type").val() == 3 || $("#vehicle_type").val() == 4 || $("#vehicle_type").val() == 5)
            //     $("#ratePerKm").val(25);
            // else
            //     $("#ratePerKm").val('');
        });

        // Validate and submit Add Vehicle Form
        $("#addVehicleForm").validate({
            rules: {
                vehicle_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                vehicle_type: 'required',
                department: 'required',
                vehicle_division: 'required',
                registration_date: 'required',
                rta_office: 'required',
                license_plate: {
                    required: true,
                    maxlength: 30
                },
                driver: 'required',
                alert_cell_no: {
                    required: true
                },
                vendor: 'required',
                alert_email: {
                    required: true,
                    email: true,
                    maxlength: 80
                },
                seat_capacity: {
                    required: true
                },
                ownership: 'required',
                chassis_number: {
                    required: true,
                    maxlength: 25
                },
                engine_number: {
                    required: true,
                    maxlength: 25
                },
                vehicle_value: {
                    required: true,
                    min: 0
                },
                uvw: {
                    number: true,
                    min: 0
                },
                cc: {
                    number: true,
                    min: 0
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                $(element).closest('div[class*=col-sm-]').append(error);
            },
            onfocusout: false,
            submitHandler: function(form, ev) {
                ev.preventDefault();

                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });
                            $("#add0").modal('hide');
                            populateVehiclesTable(vehiclesTable);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding vehicle details. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // To remove validation errors and reset Add Vehicle form on closing modal
        $("#add0").on('hidden.bs.modal', function() {
            $("#addVehicleForm").data('validator').resetForm();
            $('#addVehicleForm .form-control').each(function() {
                $(this).removeClass('error');
                $(this).removeAttr('aria-invalid');
            });
            $("#addVehicleForm").trigger('reset');

            // To prevent select2 boxes still displaying previously selected value on resetting form
            $('#add0 .basic-single').val('').trigger('change');
        });

        // To remove validation errors on resetting Add Vehicle Form
        $("#resetAddVehicleBtn").click(function() {
            $("#addVehicleForm").trigger('reset');

            // To prevent select2 boxes still displaying previously selected value on resetting form
            $('#add0 .basic-single').val('').trigger('change');
            $("#addVehicleForm").data('validator').resetForm();
            $('#addVehicleForm .form-control').each(function() {
                $(this).removeClass('error');
                $(this).removeAttr('aria-invalid');
            });

        });

        // On showing Edit Vehicle modal, enable datepicker(s)
        $("#edit").on('shown.bs.modal', function() {
            $("#editVehicleForm .edit-datepicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                autoApply: false,
                minYear: 1901,
                maxDate: moment(currentYear + '-12-31').format('DD-MMM-YYYY'),
                drops: "down",
                locale: {
                    format: 'DD-MMM-YYYY'
                },
                maxYear: parseInt(moment().format('YYYY'), 10)
            });

            $("#editVehicleForm .edit-datepicker").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $("#editVehicleForm .edit-datepicker").on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        // On selecting vehicle type in EDIT Form, set rate
        $("#new_vehicle_type").change(function() {
            let vehicle_type = $("#new_vehicle_type").val();
            let ratePerKM = '';

            // The variable used for switch case is the select value of the selected option. Since switch does strict comparison,
            // The case values are strings
            // CURRENTLY: For Auto (1): INR 20 per KM, For Car (2, 3, 4, 5, 8): INR 25 per KM
            switch (vehicle_type) {
                case '1':
                    ratePerKM = 20;
                    break;
                case '2':
                case '3':
                case '4':
                case '5':
                case '8':
                    ratePerKM = 25;
                    break;
                default:
                    ratePerKM = '';
            }

            $("#newRatePerKM").val(ratePerKM);
        });


        // Validate and submit Edit Vehicle Form for Updating Details
        $("#editVehicleForm").validate({
            rules: {
                vehicle_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                vehicle_type: 'required',
                department: 'required',
                vehicle_division: 'required',
                registration_date: 'required',
                rta_office: 'required',
                license_plate: {
                    required: true,
                    maxlength: 30
                },
                driver: 'required',
                alert_cell_no: {
                    required: true
                },
                vendor: 'required',
                alert_email: {
                    required: true,
                    email: true,
                    maxlength: 80
                },
                seat_capacity: {
                    required: true
                },
                ownership: 'required',
                chassis_number: {
                    required: true,
                    maxlength: 25
                },
                engine_number: {
                    required: true,
                    maxlength: 25
                },
                vehicle_value: {
                    required: true,
                    min: 0
                },
                uvw: {
                    number: true,
                    min: 0
                },
                cc: {
                    number: true,
                    min: 0
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                $(element).closest('div[class*=col-sm-]').append(error);
            },
            onfocusout: false,
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let url = form.action;

                url = url.substring(0, url.lastIndexOf('/') + 1);
                // url = url.replace('0', $("#editVehicleId").val());

                url += $("#editVehicleId").val();
                // console.log(url);
                // console.log($(form).serializeArray());

                $.ajax({
                    url: url,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });
                            $("#edit").modal('hide');
                            populateVehiclesTable(vehiclesTable);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error updating vehicle details. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On clicking reset button on edit vehicle  form
        $("#resetEditVehicleForm").click(function(e) {
            loadVehicleDetails($("#editVehicleId").val());
        });

        // To remove validation errors and reset Edit Vehicle form on closing modal
        $("#edit").on('hidden.bs.modal', function() {
            $("#editVehicleForm").data('validator').resetForm();
            $('#editVehicleForm .form-control').each(function() {
                $(this).removeClass('error');
                $(this).removeAttr('aria-invalid');
            });
            $("#editVehicleForm").trigger('reset');

            // To prevent select2 boxes still displaying previously selected value on resetting form
            $('#edit .basic-single').val('').trigger('change');
        });

        $("#filterVehiclesForm").submit(function(ev) {
            ev.preventDefault();
            populateVehiclesTable(vehiclesTable);
        });

        $("#btn-reset").click(function(ev) {
            // To prevent select2 boxes still displaying previously selected value on resetting form
            setTimeout(() => {
                $('#filterVehiclesForm .basic-single').val('').trigger('change');
                populateVehiclesTable(vehiclesTable);
            }, 10);
        });

        $("#resetAssignVehicleToDriverFormBtn").click(function() {
            setTimeout(() => {
                let initVal = '' + $("#vehicleDriver").attr('data-init-driver-value');
                $("#vehicleDriver").val(initVal).change();
                $("#vehicleDriver").removeClass('error').removeAttr('aria-invalid');
                $("#vehicleDriver").closest('div.form-group').find('div.error').remove();
            }, 10);
        });

        $("#assignVehicleToDriverModal").on('hidden.bs.modal', function() {
            $("#vehicleDriver").removeClass('error').removeAttr('aria-invalid');
            $("#vehicleDriver").closest('div.form-group').find('div.error').remove();
        });

        $("#assignVehicleToDriverForm").validate({
            rules: {
                vehicle_driver: 'required'
            },
            errorElement: 'div',
            errorPlacement: function(error, elem) {
                $(elem).closest('div[class^=col-sm-]').append(error);
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    type: 'post',
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });
                            $("#assignVehicleToDriverModal").modal('hide');
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function() {
                        toastr.error('Error assigning vehicle to driver. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        $("#resetAssignVehicleFormBtn").click(function() {
            setTimeout(() => {
                let initDeptVal = '' + $("#vehicleAllocatedDept").attr('data-initial-value');
                let initOwnerVal = '' + $("#vehicleAllocatedDept").attr('data-initial-value');

                $("#vehicleAllocatedDept").val(initDeptVal).change();
                $("#vehicleAllocatedDept").removeClass('error').removeAttr('aria-invalid');
                $("#vehicleAllocatedDept").closest('div.form-group').find('div.error').remove();

                $("#vehicleOwner").val(initOwnerVal).change();
                $("#vehicleOwner").removeClass('error').removeAttr('aria-invalid');
                $("#vehicleOwner").closest('div.form-group').find('div.error').remove();
            }, 10);
        });

        $("#allocateVehicleModal").on('hidden.bs.modal', function() {
            $("#vehicleAllocatedDept").removeClass('error').removeAttr('aria-invalid');
            $("#vehicleAllocatedDept").closest('div.form-group').find('div.error').remove();
            $("#vehicleOwner").removeClass('error').removeAttr('aria-invalid');
            $("#vehicleOwner").closest('div.form-group').find('div.error').remove();
        });

        $("#allocateVehicleForm").validate({
            rules: {
                vehicle_dept: 'required',
                vehicle_owner: 'required'
            },
            errorElement: 'div',
            errorPlacement: function(error, elem) {
                $(elem).closest('div[class^=col-sm-]').append(error);
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode === 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });
                            $("#allocateVehicleModal").modal('hide');
                            populateVehiclesTable(vehiclesTable);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function() {
                        toastr.error('Error adding details. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

    });
    // End of document.ready function
</script>

<script>
    function populateVehiclesTable(table) {
        $.ajax({
            url: "{{url('vehicle-details')}}",
            type: 'post',
            data: {
                _token: '{{csrf_token()}}',
                search_department: $("#search_department").val(),
                vehicle_typesr: $("#vehicle_typesr").val(),
                ownershipsr: $("#ownershipsr").val(),
                registration_date_fr: $("#registration_date_fr").val(),
                registration_date_to: $("#registration_date_to").val(),
                vendorsr: $("#vendorsr").val(),
                is_activesr: $("#filterIsActive").val()
            },
            // data: $("#filterVehiclesForm").serialize() + '&_token=' + '{{csrf_token()}}',
            dataType: 'json',
            beforeSend: function() {
                $("#table-loader").show();
            },
            success: function(res) {
                table.clear();
                $.each(res, function(i, data) {
                    console.log(data);
                    let buttons = '<button class="btn btn-sm btn-primary mr-1" data-id="' + data.VEHICLE_ID + '" onclick="editInfo(this)" title="Edit"><i class="fa fa-edit"></i></button>';
                    let registrationDate = moment(data.REGISTRATION_DATE).format('DD-MMM-YYYY');

                    if (data.IS_ACTIVE == 'Y')
                        buttons += '<button class="btn btn-sm btn-danger mr-1" data-id="' + data.VEHICLE_ID + '" onclick="updateStatus(this)" title="Deactivate"><i class="ti-close"></i></button>';
                    else
                        buttons += '<button class="btn btn-sm btn-success mr-1" data-id="' + data.VEHICLE_ID + '" onclick="updateStatus(this)" title="Activate"><i class="ti-reload"></i></button>';

                    if (data.DRIVER_ID == 0)
                        buttons += '<button class="btn btn-sm btn-success mr-1" data-id="' + data.VEHICLE_ID + '" onclick="assignToDriver(this)" title="Assign to Driver"><i class="fas fa-user-plus"></i></button>';
                    else
                        buttons += '<button class="btn btn-sm btn-danger mr-1" data-id="' + data.VEHICLE_ID + '" onclick="assignToDriver(this)" title="Assign to Driver"><i class="fas fa-user-plus"></i></button>';

                    if (data.DEPARTMENT_ID == 0)
                        buttons += '<button class="btn btn-sm btn-success mr-1" data-id="' + data.VEHICLE_ID + '" onclick="allocateVehicle(this)" title="Allocate Vehicle to User"><i class="fas fa-user-check"></i></button>';
                    else
                        buttons += '<button class="btn btn-sm btn-danger mr-1" data-id="' + data.VEHICLE_ID + '" onclick="allocateVehicle(this)" title="Allocate Vehicle to User"><i class="fas fa-user-check"></i></button>';
                    table.row.add(
                        [i + 1,
                            data.VEHICLE_NAME,
                            data.VEHICLE_TYPE_NAME,
                            data.LICENSE_PLATE,
                            data.DEPARTMENT_NAME,
                            registrationDate,
                            data.OWNERSHIP_NAME,
                            data.VENDOR_NAME,
                            buttons
                        ]);
                });
                table.draw();

            },
            error: function(xhr, status, err) {
                console.log("Error fetching data");
            },
            complete: function() {
                $("#table-loader").hide();
            }
        });
    }

    // Load data to Edit Vehicle Form
    function loadVehicleDetails(vehicleId) {
        $.ajax({
            url: "{{route('vehicle.get-details')}}",
            type: 'post',
            data: {
                _token: '{{csrf_token()}}',
                vehicle_id: vehicleId
            },
            dataType: 'json',
            beforeSend: function() {
                $('.customloader').show();
            },
            success: function(res) {
                if (res.successCode == 1) {
                    // console.log(res.data);
                    let uvw = res.data.UVW ? res.data.UVW : '';
                    let cc = res.data.CC ? res.data.CC : '';
                    let vehicleValue = res.data.VEHICLE_VALUE ? res.data.VEHICLE_VALUE : '';
                    let ratePerKm = res.data.RATE_PER_KM ? res.data.RATE_PER_KM : '';

                    $("#new_vehicle_name").val(res.data.VEHICLE_NAME);
                    $("#new_vehicle_type").val(res.data.VEHICLE_TYPE_ID);

                    let deptValue = res.data.DEPARTMENT_ID + '|' + res.data.DEPARTMENT_NAME;
                    $("#newVehicleDept").val(deptValue);
                    $("#newVehicleDept").select2().trigger('change');

                    $("#new_vehicle_division").val(res.data.VEHICLE_DIVISION_ID).trigger('change');
                    $("#new_registration_date").val(moment(res.data.REGISTRATION_DATE).format('DD-MMM-YYYY'));
                    $("#new_rta_office").val(res.data.RTA_CIRCLE_OFFICE_ID);
                    $("#new_license_plate").val(res.data.LICENSE_PLATE);

                    $("#new_al_cell_no").val(res.data.ALERT_CELL_NUMBER);
                    $("#new_vendor").val(res.data.VENDOR_ID);
                    $("#new_al_email").val(res.data.ALERT_EMAIL_ID);
                    $("#new_seat_capacity").val(res.data.SEAT_CAPACITY);

                    let ownershipVal = res.data.OWNERSHIP_ID + '|' + res.data.OWNERSHIP_NAME;
                    $("#new_ownership").val(ownershipVal).trigger('change');

                    $("#new_chassis_number").val(res.data.CHASSIS_NUMBER);
                    $("#new_engine_number").val(res.data.ENGINE_NUMBER);
                    $("#new_vehicle_value").val(vehicleValue);
                    $("#new_uvw").val(uvw);
                    $("#new_cc").val(cc);
                    $("#newRatePerKM").val(ratePerKm);
                } else {
                    console.log("Could not fetch details");
                    $("#edit").modal('hide');
                    toastr.error("Error fetching details. Please try again", "", {
                        closeButton: true
                    });
                }
            },
            error: function(xhr, status, err) {
                console.log("Error occurred while fetching details");
                $("#edit").modal('hide');
            },
            complete: function() {
                $('.customloader').hide();
            }
        });
    }

    function editInfo(vehicle) {
        let vehicle_id = $(vehicle).attr('data-id');
        $("#editVehicleId").val(vehicle_id);
        loadVehicleDetails(vehicle_id);
        $("#edit").modal('show');
    }

    function assignToDriver(el) {
        $("#driverAllocationVehicleId").val($(el).data('id'));
        $.ajax({
            url: "{{route('vehicle.get-details')}}",
            type: 'post',
            data: {
                _token: "{{csrf_token()}}",
                vehicle_id: $(el).data('id')
            },
            dataType: 'json',
            success: function(res) {
                if (res.successCode === 1) {
                    $("#driverAssignedVehicle").attr('value', res.data.VEHICLE_NAME);
                    if (res.data.DRIVER_ID !== 0) {
                        $("#vehicleDriver").val(res.data.DRIVER_ID).trigger('change');
                        $("#vehicleDriver").attr('data-init-driver-value', res.data.DRIVER_ID); // For storing value in case of form reset
                    } else {
                        $("#vehicleDriver").val("").trigger('change');
                        $("#vehicleDriver").attr('data-init-driver-value', "");
                    }

                    $("#assignVehicleToDriverModal").modal('show');
                } else {
                    toastr.error("Could not get details", "", {
                        closeButton: true
                    });
                }
            },
            error: function(jqXHR, textStatus, err) {
                toastr.error("Error getting details. Please try again", "", {
                    closeButton: true
                });
            }
        });
    }

    function allocateVehicle(el) {
        $("#allocatedVehicleId").val($(el).data('id'));
        $.ajax({
            url: "{{route('vehicle.get-details')}}",
            type: 'post',
            data: {
                _token: "{{csrf_token()}}",
                vehicle_id: $(el).data('id')
            },
            dataType: 'json',
            beforeSend: function() {
                $('.customloader').show();
            },
            success: function(res) {
                if (res.successCode == 1) {
                    $("#allocatedVehicle").attr('value', res.data.VEHICLE_NAME);
                    if (res.data.DEPARTMENT_ID.trim() !== '' && res.data.DEPARTMENT_ID != null && res.data.DEPARTMENT_ID != 0) {
                        let deptVal = res.data.DEPARTMENT_ID + '|' + res.data.DEPARTMENT_NAME;
                        $("#vehicleAllocatedDept").val(deptVal).trigger('change');
                        $("#vehicleAllocatedDept").attr('data-initial-value', deptVal);
                    } else {
                        $("#vehicleAllocatedDept").val("").change();
                        $("#vehicleAllocatedDept").attr('data-initial-value', "");
                    }

                    if (res.data.EMPLOYEE_ID.trim() != '' && res.data.EMPLOYEE_ID != null && res.data.EMPLOYEE_ID != 0) {
                        let empVal = res.data.EMPLOYEE_ID + '|' + res.data.EMPLOYEE_NAME;
                        $("#vehicleOwner").val(empVal).trigger('change');
                        $("#vehicleOwner").attr('data-initial-value', empVal);
                    } else {
                        $("#vehicleOwner").val("").trigger('change');
                        $("#vehicleOwner").attr('data-initial-value', "");
                    }

                    $("#allocateVehicleModal").modal('show');
                    $('.customloader').hide();

                } else {
                    toastr.error("Error getting details. Please try again", "", {
                        closeButton: true
                    });
                    $('.customloader').hide();
                }
            },
            error: function() {
                toastr.error("Error getting details. Please try again", "", {
                    closeButton: true
                });
                $('.customloader').hide();
            }
        });
    }

    function getEmployeesByDept(el) {
        let dept = $(el).val();
        // console.log($(el));
        // console.log(dept);
        $.ajax({
            url: "{{route('vehicle.get-employees')}}",
            type: 'post',
            data: {
                _token: "{{csrf_token()}}",
                department: dept
            },
            beforeSend: function() {
                $('.customloader').show();
            },
            success: function(res) {
                // console.log(res);
                if (res.successCode == 1) {
                    if (res.data.length >= 1) {
                        $("#vehicleOwner").empty();
                        $("#vehicleOwner").append('<option value="">Please Select Owner</option>');
                        $.each(res.data, function(i, data) {
                            let isSelected = $("#vehicleOwner").attr('data-initial-value');
                            let currentVal = data.hrEmployeeId + '|' + data.employeeName;
                            if (isSelected == currentVal)
                                $("#vehicleOwner").append('<option value="' + currentVal + '" selected>' + data.employeeName + '</option>');
                            else
                                $("#vehicleOwner").append('<option value="' + currentVal + '">' + data.employeeName + '</option>');
                        });

                    } else {
                        $("#vehicleOwner").empty();
                        $("#vehicleOwner").append('<option value="">Please Select Owner</option>');
                    }
                } else {
                    $("#vehicleOwner").empty();
                    $("#vehicleOwner").append('<option value="">Please Select Owner</option>');
                }
            },
            error: function() {
                toastr.error("Error loading employees. Please try again", "", {
                    closeButton: true
                });
            },
            complete: function() {
                $('.customloader').hide();
            }
        });
    }

    function setEmployeeVal() {
        // In assign vehicle to employee form, on loading employees, value gets over-ridden to ""
        // To change it back
        let setValue = $("#vehicleOwner").attr('data-initial-value');
        $("#vehicleOwner").val(setValue).change();
    }

    function updateStatus(el) {
        let vehicleId = $(el).attr('data-id');

        toastr.remove();
        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('vehicle.status-update') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            vehicle_id: vehicleId
                        },
                        success: function(response) {
                            toastr.remove();

                            if (response['IS_ACTIVE'] == 'Y') {
                                $(el).removeClass('btn-success').addClass('btn-danger');
                                $(el).html('<i class="ti-close"></i>');
                                $(el).attr('title', 'Deactivate');

                            } else {
                                $(el).removeClass('btn-danger').addClass('btn-success');
                                $(el).html('<i class="ti-reload"></i>');
                                $(el).attr('title', 'Activate');
                            }

                            toastr.success('Status Updated', '', {
                                closeButton: true
                            });
                        }
                    });

                } else {
                    toastr.remove();
                }
            }

        });
    }
</script>
@endsection