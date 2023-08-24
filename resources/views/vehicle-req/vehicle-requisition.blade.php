@extends('layouts.main.app')

@section('title', 'Vehicle Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Requisition</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Requisition</h1>
<small id="controllerName">Manage Vehicle Requisitions</small>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add" data-toggle="modal"><i
                                class="ti-plus" aria-hidden="true"></i>
                            Add Requisition</button>
                    </small></h4>
            </div>
            <form id="searchform" method="get">
                <div class="card-body row">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="req_forsr"
                                class="col-sm-5 col-form-label justify-content-start text-left">Requisition For </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="req_forsr" id="req_forsr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($empData as $val)
                                    <option value="{{$val['employeeId']}}">{{$val['employeeName']}}
                                        ({{$val['department']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="vehicle_typesr"
                                class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle_typesr" id="vehicle_typesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicle_type as $val)
                                    <option value="{{$val->VEHICLE_TYPE_ID}}">{{$val->VEHICLE_TYPE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="from" class="col-sm-5 col-form-label justify-content-start text-left">Time From
                            </label>
                            <div class="col-sm-7">
                                <input name="from" autocomplete="off" class="form-control vnewdatetimepicker w-100"
                                    type="time" placeholder="From" id="from">
                            </div>

                        </div>
                        <div class="form-group row mb-1">
                            <label for="to" class="col-sm-5 col-form-label justify-content-start text-left">Time To
                            </label>
                            <div class="col-sm-7">
                                <input name="to" autocomplete="off" class="form-control vnewdatetimepicker w-100"
                                    type="time" placeholder="To" id="to">
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status
                                <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="status" id="status">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="P">Pending</option>
                                    <option value="A">Approved </option>
                                    <option value="R">Rejected </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row  mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 text-right">
                                <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Requisition List</h4>
            </div>
            <div class="card-body pl-3 pr-3">
                <div class="table-responsive">
                    <table id="dataTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requisition For</th>
                                <th>Requisition Date</th>
                                <th>Driver Name</th>
                                <th>Requested By </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_data">

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<div id="add" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form" action="{{route('add_requisition')}}" class="row" enctype="multipart/form-data"
                    method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="req_for" class="col-sm-5 col-form-label">Requisition For <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="req_for" id="req_for">
                                    <option value="" selected="selected">Select Employee</option>
                                    @foreach($empData as $val)
                                    <option value="{{$val['employeeId']}}">{{$val['employeeName']}}
                                        ({{$val['department']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_type" class="col-sm-5 col-form-label">Vehicle Type <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_type"
                                    id="vehicle_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicle_type as $val)
                                    <option value="{{$val->VEHICLE_TYPE_ID}}">{{$val->VEHICLE_TYPE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_fr" class="col-sm-5 col-form-label">Where From <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_fr" required="" class="form-control" type="text"
                                    placeholder="Where From" id="where_fr">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_to" required="" class="col-sm-5 col-form-label">Where To <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_to" required="" class="form-control" type="text"
                                    placeholder="Where To" id="where_to">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pickup" class="col-sm-5 col-form-label">Pick Up <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="pickup" class="form-control" type="text" placeholder="Pick Up" id="pickup">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_date" class="col-sm-5 col-form-label">Requisition Date <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_date" class="form-control  vnewdatetimepicker" autocomplete="off"
                                    type="date" placeholder="Requisition Date" id="req_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_fr" class="col-sm-5 col-form-label">Time From <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="time_fr" class="form-control ttimepicker" type="time"
                                    placeholder="Time From" id="time_fr">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="time_to" class="col-sm-5 col-form-label">Time To <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="time_to" class="form-control ttimepicker" type="time" placeholder="Time To"
                                    id="time_to">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tolerance" class="col-sm-5 col-form-label">Tolerance Duration <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="tolerance" required="" class="form-control" type="time"
                                    placeholder="Tolerance Duration" id="tolerance">
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <label for="purpose" class="col-sm-5 col-form-label">Vehicle <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle" id="vehicle">
                                    <option value="" selected="selected">Please Select One</option>

                                </select>
                            </div>
                            <div class="col-sm-12 text-right mt-2">
                                <span class="mt-2"><input type="checkbox" id="aloc_checkbox"> &nbsp;Add Allocated Vehicles</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nunpassenger" class="col-sm-5 col-form-label">No of Passenger <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="nunpassenger" class="form-control" type="number"
                                    placeholder="No of Passenger" id="nunpassenger">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="purpose" class="col-sm-5 col-form-label">Purpose <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="purpose" id="purpose">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($purpose as $val)
                                    <option value="{{$val->REQUISITION_PURPOSE_ID}}">{{$val->REQUISITION_PURPOSE_NAME}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="details" class="col-sm-5 col-form-label">Details <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="details" required="" class="form-control" type="text" placeholder="Details"
                                    id="details">
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
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form2" action="{{route('edit_requisition')}}" class="row" enctype="multipart/form-data"
                    method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="id" id="requsition_id" value="">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="req_for" class="col-sm-5 col-form-label">Requisition For <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="req_for" id="req_for2">
                                    <option value="" selected="selected">Select Employee</option>
                                    @foreach($empData as $val)
                                    <option value="{{$val['employeeId']}}">{{$val['employeeName']}}
                                        ({{$val['department']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_type" class="col-sm-5 col-form-label">Vehicle Type <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_type"
                                    id="vehicle_type2">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicle_type as $val)
                                    <option value="{{$val->VEHICLE_TYPE_ID}}">{{$val->VEHICLE_TYPE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_fr" class="col-sm-5 col-form-label">Where From <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_fr" required="" class="form-control" type="text"
                                    placeholder="Where From" id="where_fr2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_to" required="" class="col-sm-5 col-form-label">Where To <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_to" required="" class="form-control" type="text"
                                    placeholder="Where To" id="where_to2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pickup" class="col-sm-5 col-form-label">Pick Up <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="pickup" class="form-control" type="text" placeholder="Pick Up"
                                    id="pickup2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_date" class="col-sm-5 col-form-label">Requisition Date <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_date" class="form-control  vnewdatetimepicker" autocomplete="off"
                                    type="date" placeholder="Requisition Date" id="req_date2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_fr" class="col-sm-5 col-form-label">Time From <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="time_fr" class="form-control ttimepicker" type="time"
                                    placeholder="Time From" id="time_fr2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="time_to" class="col-sm-5 col-form-label">Time To <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="time_to" class="form-control ttimepicker" type="time" placeholder="Time To"
                                    id="time_to2">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tolerance" class="col-sm-5 col-form-label">Tolerance Duration <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="tolerance" required="" class="form-control" type="time"
                                    placeholder="Tolerance Duration" id="tolerance2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nunpassenger" class="col-sm-5 col-form-label">No of Passenger <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="nunpassenger" class="form-control" type="number"
                                    placeholder="No of Passenger" id="nunpassenger2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="purpose" class="col-sm-5 col-form-label">Purpose <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="purpose" id="purpose2">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($purpose as $val)
                                    <option value="{{$val->REQUISITION_PURPOSE_ID}}">{{$val->REQUISITION_PURPOSE_NAME}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="details" class="col-sm-5 col-form-label">Details <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="details" required="" class="form-control" type="text" placeholder="Details"
                                    id="details2">
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="driverModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Driver</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="driverform" action="{{route('add_driver')}}" class="" enctype="multipart/form-data"
                    method="post" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="drivenby" class="form-label">Driven By <i class="text-danger">*</i></label>
                            <input type="hidden" name="req_id" value="" id="req_id">
                            <select class="form-control basic-single" required="" name="drivenby" id="drivenby">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($driver as $val)
                                <option value="{{$val->DRIVER_ID}}">{{$val->DRIVER_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 text-right mt-3">
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="statusModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Status</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="statusform" action="{{route('update_status')}}" class="" enctype="multipart/form-data"
                    method="post" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="drivenby" class="form-label">Status <i class="text-danger">*</i></label>
                            <input type="hidden" name="req_id" value="" id="st_req_id">
                            <select class="form-control" required="" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="A">Approve</option>
                                <option value="R">Reject</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-right mt-3">
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/vehiclereq_requisition_list.js"></script> -->
<style>
#dataTable {
    width: 100% !important;
}
</style>
<script>
$(document).ready(function() {
    var table = $("#dataTable");
    getdata();
    $(document).on('click', '#btn-filter', function(e) {
        $('#dataTable').DataTable().ajax.reload(null, false);
    });

    function getdata() {

        $("#dataTable").DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{route('vehicle-requisitions')}}",
                data: function(d) {
                    d.req_forsr = $('#req_forsr').val();
                    d.vehicle_typesr = $('#vehicle_typesr').val();
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                    d.status = $('#status').val();
                }
            },
            columns: [{
                    data: 'VEHICLE_REQ_ID',
                    name: 'VEHICLE_REQ_ID',
                },
                {
                    data: 'req_for',
                    name: 'req_for'
                },
                {
                    data: 'req_date',
                    name: 'req_date'
                },
                {
                    data: 'driver',
                    name: 'driver'
                },
                {
                    data: 'create_by',
                    name: 'create_by'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ],

        });
    }

    $('body').on('click', '.driver-modal', function() {
        var val = $(this).data('driverid');
        var id = $(this).data('id');
        $('#drivenby').val(val).trigger('change');
        $('#req_id').val(id);
    });

    $("#driverform").validate({
        rules: {
            drivenby: {
                required: true,
            },
        },
        submitHandler: function(form, ev) {
            ev.preventDefault();
            $.ajax({
                url: form.action,
                method: form.method,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: $(form).serialize(),
                success: function(data) {
                    if (data.error == false) {
                        $('#driverform').find('select').val('');
                        $('.basic-single').val('').trigger('change');
                        toastr.success(data.msg);
                        $('#driverModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload(null, false);
                        // location.reload();
                    } else {
                        toastr.error(data.msg);
                    }
                },
                error: function(jqXHR, textStatus, err) {
                    toastr.error("Error Updating Driver. Please try again", '', {
                        closeButton: true
                    });
                }
            });
        }
    });
    $('body').on('click', '.statusModal', function() {
        var id = $(this).data('id');
        $('#st_req_id').val(id);
    });
    $("#statusform").validate({
        rules: {
            status: {
                required: true,
            },
        },
        submitHandler: function(form, ev) {
            ev.preventDefault();
            $.ajax({
                url: form.action,
                method: form.method,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: $(form).serialize(),
                success: function(data) {
                    if (data.error == false) {
                        $('#statusform').find('select').val('');
                        toastr.success(data.msg);
                        $('#statusModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload(null, false);
                        // location.reload();
                    } else {
                        toastr.error(data.msg);
                    }
                },
                error: function(jqXHR, textStatus, err) {
                    toastr.error("Error Updating Status. Please try again", '', {
                        closeButton: true
                    });
                }
            });
        }
    });
    $("#form").validate({
        rules: {
            req_for: {
                required: true,
            },
            vehicle_type: {
                required: true,
            },
            vehicle: {
                required: true,
            },
            where_fr: {
                required: true,
            },
            where_to: {
                required: true,
            },
            pickup: {
                required: true,
            },
            req_date: {
                required: true,
            },
            time_fr: {
                required: true,
            },
            time_to: {
                required: true,
            },
            tolerance: {
                required: true,
            },
            nunpassenger: {
                required: true,
            },
            purpose: {
                required: true,
            },
            details: {
                required: true,
            }
        },
        submitHandler: function(form, ev) {
            ev.preventDefault();
            $.ajax({
                url: form.action,
                method: form.method,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: $(form).serialize(),
                success: function(data) {
                    if (data.error == false) {
                        $('#form').find('input').val('');
                        $('#form').find('select').val('');
                        $('.basic-single').val('').trigger('change');

                        toastr.success(data.msg);
                        $('#add').modal('hide');
                        $('#dataTable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error(data.msg);
                    }
                },
                error: function(jqXHR, textStatus, err) {
                    toastr.error("Error Adding Booking. Please try again", '', {
                        closeButton: true
                    });
                }
            });
        }
    });

    $("#form2").validate({
        rules: {
            req_for: {
                required: true,
            },
            vehicle_type: {
                required: true,
            },
            where_fr: {
                required: true,
            },
            where_to: {
                required: true,
            },
            pickup: {
                required: true,
            },
            req_date: {
                required: true,
            },
            time_fr: {
                required: true,
            },
            time_to: {
                required: true,
            },
            tolerance: {
                required: true,
            },
            nunpassenger: {
                required: true,
            },
            purpose: {
                required: true,
            },
            details: {
                required: true,
            }
        },
        submitHandler: function(form, ev) {
            ev.preventDefault();
            $.ajax({
                url: form.action,
                method: form.method,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: $(form).serialize(),
                success: function(data) {
                    if (data.error == false) {
                        $('#form2').find('input').val('');
                        toastr.success(data.msg);
                        $('#edit').modal('hide');
                        $('#dataTable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error(data.msg);
                    }
                },
                error: function(jqXHR, textStatus, err) {
                    toastr.error("Error updating. Please try again", '', {
                        closeButton: true
                    });
                }
            });
        }
    });
    $('body').on('click', '.editModal', function() {
        var id = $(this).data('id');
        $('#edit').modal('show');
        $.ajax({
            url: '{{route("get.req.data")}}',
            type: 'get',
            dataType: 'json',
            data: {
                req_id: id,
            },
            success: function(res) {
                $('#requsition_id').val(res.VEHICLE_REQ_ID);
                $('#req_for2').val(res.REQUISITION_FOR).trigger('change');
                $('#vehicle_type2').val(res.VEHICLE_TYPE_ID).trigger('change');
                $('#where_fr2').val(res.WHERE_FROM);
                $('#where_to2').val(res.WHERE_TO);
                $('#pickup2').val(res.PICK_UP);
                $('#req_date2').val(res.REQUISITION_DATE);
                $('#time_fr2').val(res.TIME_FROM);
                $('#time_to2').val(res.TIME_TO);
                $('#tolerance2').val(res.TOLERANCE_DURATION);
                $('#nunpassenger2').val(res.NUMBER_OF_PASSENGER);
                $('#purpose2').val(res.REQUISITION_PURPOSE_ID).trigger('change');
                $('#details2').val(res.DETAILS);
            }
        });
    });
    $('body').on('change', '#vehicle_type', function() {
        getVehicle();
    });
    $('body').on('change', '#req_date', function() {
        getVehicle();
    });
    $('body').on('change', '#vehicle_type', function() {
        getVehicle();
    });
    $('body').on('change', '#vehicle_type', function() {
        getVehicle();
    });
    $('body').on('click', '#aloc_checkbox', function() {
        getVehicle();
    });
    function getVehicle(){
       var chk = $('#aloc_checkbox').is(':checked'); 
       var type = $('#vehicle_type').val();
       var rdate = $('#req_date').val();
       var frmt = $('#time_fr').val();
       var tot = $('#time_to').val();
       $.ajax({
           url: '{{route("get.vehicle.data")}}',
           type: 'get',
           dataType: 'html',
           data: {
               type: type,
               rdate: rdate,
               frmt: frmt,
               tot: tot,
               checked:chk
           },
           success: function(res) {
               $('#vehicle').html(res);
           }
       });
    }
    $('body').on('change', '#vehicle', function() {
        var selectedOption = $(this).find('option:selected');
        var newLimit = parseInt(selectedOption.attr('data-limit'));
        $('#nunpassenger').attr('max', newLimit);
    });
    // Remove validations, errors and reset add vehicle type form on closing modal
    $("#add").on('hidden.bs.modal', function(ev) {
        $("#form").trigger('reset');
        $("#form").validate().resetForm();
    });

    // Remove validations, errors and reset add vehicle type form on closing modal
    $("#edit").on('hidden.bs.modal', function(ev) {
        $("#form2").trigger('reset');
        $("#form2").validate().resetForm();
    });


});
</script>
@endsection