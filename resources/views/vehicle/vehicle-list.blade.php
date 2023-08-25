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
                <strong>Vehicle List</strong>
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
                            <label for="vehicleDept" class="col-sm-5 col-form-label">Department<i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="vehicleDept">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department['deptCode'] }}">{{ $department['deptName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="registration_date" class="col-sm-5 col-form-label">Registration Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="registration_date" required="" class="form-control newdatetimepicker" type="text" placeholder="Registration Date" id="registration_date">
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
                                    @foreach($ownerships as $ownership)
                                    <option value="{{$ownership['OWNERSHIP_ID']}}">{{$ownership['OWNERSHIP_NAME']}}</option>
                                    @endforeach
                                </select>
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
                            <label for="driver" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="driver" id="driver">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}"> {{$driver['DRIVER_NAME']}} </option>
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
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
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
                            <label for="newVehicleDept" class="col-sm-5 col-form-label">Department<i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="newVehicleDept">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department['deptCode'] }}">{{ $department['deptName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_registration_date" class="col-sm-5 col-form-label">Registration Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="registration_date" required="" class="form-control newdatetimepicker" type="text" placeholder="Registration Date" id="new_registration_date">
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
                                    @foreach($ownerships as $ownership)
                                    <option value="{{$ownership['OWNERSHIP_ID']}}">{{$ownership['OWNERSHIP_NAME']}}</option>
                                    @endforeach
                                </select>
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
                            <label for="new_driver" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="driver" id="new_driver">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}"> {{$driver['DRIVER_NAME']}} </option>
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
                        <div class="form-group text-right">
                            <button type="reset" id="resetEditVehicleForm" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div> <!-- End modal for editing vehcile details-->

<!-- Modal for assigning driver the selected vehicle -->
<div id="assignVehicleToDriverModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Assign Driver</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="assignVehicleToDriverForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="vehicle_id" id="driverAllocationVehicleId" value="">
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="driverAssignedVehicle" class="col-sm-12 col-lg-4 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-8">
                                <input class="form-control" id="driverAssignedVehicle" type="text" name="" value="Test Cab" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="vehicleDriver" class="col-sm-12 col-lg-4 col-form-label">Driver <i class="text-danger">*</i></label>
                            <div class="col-sm-12 col-lg-8">
                                <select name="vehicle_driver" id="vehicleDriver" class="form-control basic-single">
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
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Vehicle
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form id="filterVehiclesForm" action="" method="post" class="row">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="search_department" class="col-sm-4 col-form-label justify-content-start text-left">Department </label>
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
                                    @foreach($ownerships as $ownership)
                                    <option value="{{$ownership['OWNERSHIP_ID']}}">{{$ownership['OWNERSHIP_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-5">
                        <div class="form-group row mb-1">
                            <label for="registration_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Registration Date From </label>
                            <div class="col-sm-6">
                                <input name="registration_date_fr" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Registration Date From" id="registration_date_fr">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="registration_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Registration Date To </label>
                            <div class="col-sm-6">
                                <input name="registration_date_to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Registration Date To" id="registration_date_to">
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
                        <div class="form-group row mb-1">
                            <div class="col-sm-8 text-right">
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
                    <table id="vehicinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Department</th>
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
<!-- <script src="{{asset('dist/js/vehicle_list.js')}}"></script> -->
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        var vehiclesTable = $("#vehicinfo").DataTable({
            paging: true,
            lengthMenu: [5, 10, 15, 20, 25],
            pageLength: 5
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
                ownership: 'required'
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
                ownership: 'required'
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                $(element).closest('div[class*=col-sm-]').append(error);
            },
            onfocusout: false,
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let url = form.action;
                url = url.replace('0', $("#editVehicleId").val());
                console.log(url);
                console.log($(form).serializeArray());

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
        })

    });

    // To prevent select2 boxes still displaying previously selected value on resetting form
    $('#filterVehiclesForm .basic-single').val('').trigger('change');
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
                vendorsr: $("#vendorsr").val()
            },
            dataType: 'json',
            success: function(res) {
                table.clear();
                $.each(res, function(i, data) {
                    // console.log(data);
                    let buttons = '<button class="btn btn-sm btn-primary mr-1" data-id="' + data.VEHICLE_ID + '" onclick="editInfo(this)" title="Edit"><i class="fa fa-edit"></i></button>';
                    if (data.IS_ACTIVE == 'Y')
                        buttons += '<button class="btn btn-sm btn-danger mr-1" data-id="' + data.VEHICLE_ID + '" onclick="updateStatus(this)" title="Deactivate"><i class="ti-close"></i></button>';
                    else
                        buttons += '<button class="btn btn-sm btn-success mr-1" data-id="' + data.VEHICLE_ID + '" onclick="updateStatus(this)" title="Activate"><i class="ti-reload"></i></button>';

                    if (data.DRIVER_ID == 0)
                        buttons += '<button class="btn btn-sm btn-success mr-1" data-id="' + data.VEHICLE_ID + '" onclick="assignToDriver(this)" title="Assign to Driver"><i class="fas fa-user-plus"></i></button>';
                    else
                        buttons += '<button class="btn btn-sm btn-danger mr-1" data-id="' + data.VEHICLE_ID + '" onclick="assignToDriver(this)" title="Assign to Driver"><i class="fas fa-user-plus"></i></button>';
                    table.row.add(
                        [i + 1,
                            data.VEHICLE_NAME,
                            data.VEHICLE_TYPE_NAME,
                            data.DEPARTMENT_NAME,
                            data.REGISTRATION_DATE,
                            data.OWNERSHIP_NAME,
                            data.VENDOR_NAME,
                            buttons
                        ]);
                });
                table.draw(false);

            },
            error: function(xhr, status, err) {
                console.log("Error fetching data");
            }
        });
    }

    // Load data to Edit Vehicle From
    function loadVehicleDetails(vehicleId) {
        $.ajax({
            url: "{{route('vehicle.get-details')}}",
            type: 'post',
            data: {
                _token: '{{csrf_token()}}',
                vehicle_id: vehicleId
            },
            dataType: 'json',
            success: function(res) {
                if (res.successCode == 1) {
                    console.log(res.data);
                    $("#new_vehicle_name").val(res.data.VEHICLE_NAME);
                    $("#new_vehicle_type").val(res.data.VEHICLE_TYPE_ID);
                    $("#newVehicleDept").val(res.data.DEPARTMENT_ID);
                    $("#newVehicleDept").select2().trigger('change');
                    $("#new_vehicle_division").val(res.data.VEHICLE_DIVISION_ID).trigger('change');
                    $("#new_registration_date").val(res.data.REGISTRATION_DATE);
                    $("#new_rta_office").val(res.data.RTA_CIRCLE_OFFICE_ID);
                    $("#new_license_plate").val(res.data.LICENSE_PLATE);
                    $("#new_driver").val(res.data.DRIVER_ID).trigger('change');
                    $("#new_al_cell_no").val(res.data.ALERT_CELL_NUMBER);
                    $("#new_vendor").val(res.data.VENDOR_ID);
                    $("#new_al_email").val(res.data.ALERT_EMAIL_ID);
                    $("#new_seat_capacity").val(res.data.SEAT_CAPACITY);
                    $("#new_ownership").val(res.data.OWNERSHIP_ID).trigger('change');
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
        $("#assignVehicleToDriverModal").modal('show');
    }

    function allocateVehicle(el) {

    }

    function updateStatus(el) {
        let vehicleId = $(el).attr('data-id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
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