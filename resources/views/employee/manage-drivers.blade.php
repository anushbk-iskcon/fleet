@extends('layouts.main.app')

@section('title', 'Manage Drivers')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Driver Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Driver Management</h1>
<small id="controllerName">Manage Drivers</small>
@endsection
@section('css-content')
<!-- <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css' rel='stylesheet'> -->
<style>
    #driverinfo tbody td {
        vertical-align: middle;
    }
</style>
@endsection
@section('content')
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Driver</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('drivers.store')}}" id="add_driver_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="driver_name" class="col-sm-5 col-form-label">Driver Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="driver_name" required="" class="form-control" type="text" placeholder="Driver Name" id="driver_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_number" class="col-sm-5 col-form-label">License Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="license_number" required="" class="form-control" type="text" placeholder="License Number" id="license_number" autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="national_id" class="col-sm-5 col-form-label">National ID <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="national_id" required="" class="form-control" type="number" placeholder="National ID" id="national_id" autocomplete="off">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="timeslot" required="" class="col-sm-5 col-form-label">Working Time Slot <i class="text-danger">*</i></label>
                            <div class="col-sm-3 pr-0">
                                <input name="timeslot_start" class="form-control time-picker" type="text" placeholder="09:00 AM" id="timeslotStart" value="" autocomplete="off">
                            </div>
                            <div class="col-sm-1"><sub>&ndash;</sub></div>
                            <div class="col-sm-3 pl-0">
                                <input name="timeslot_end" class="form-control time-picker" type="text" placeholder="05:00 PM" id="timeslotEnd" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dob" class="col-sm-5 col-form-label">Date of Birth </label>
                            <div class="col-sm-7">
                                <input name="dob" autocomplete="off" class="form-control date-picker" type="text" placeholder="Date of Birth" id="dob">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="present_address" class="col-sm-5 col-form-label">Present Address <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input name="present_address" class="form-control" type="text" placeholder="Present Address" id="present_address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="distanceFromTemple" class="col-sm-5 col-form-label"> Distance From Temple (in km) </label>
                            <div class="col-sm-7">
                                <input name="distance_from_temple" class="form-control" type="text" placeholder="Distance in km" id="distanceFromTemple">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="travelMode" class="col-sm-5 col-form-label">Mode of Travel </label>
                            <div class="col-sm-7">
                                <input name="mode_of_travel" class="form-control" type="text" placeholder="Mode of Travel" id="travelMode">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="checkbox2" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="is_active">
                                <label for="checkbox2">Is Active</label>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="permanent_address" class="col-sm-5 col-form-label">Permanent Address </label>
                            <div class="col-sm-7">
                                <input name="permanent_address" class="form-control" type="text" placeholder="Permanent Address" id="permanent_address">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="picture" class="col-sm-5 col-form-label">Photograph </label>
                            <div class="col-sm-7" style="display:flex;flex-wrap:wrap;">
                                <input type="file" accept="image/*" name="picture" onchange="loadFile(event)">
                                <div id="selectedFileName"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-5 col-form-label">Mobile <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="mobile" required="" class="form-control" type="number" placeholder="Mobile" id="mobile">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="license_type" class="col-sm-5 col-form-label">License Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="license_type" id="license_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($licenseTypes as $licenseType)
                                    <option value="{{$licenseType->LICENSE_ID}}">{{$licenseType->LICENSE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_issue_date" class="col-sm-5 col-form-label">License Issue Date <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input name="license_issue_date" class="form-control date-picker" type="text" placeholder="License Issue Date" id="license_issue_date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="join_date" class="col-sm-5 col-form-label">Join Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="join_date" class="form-control date-picker" type="text" placeholder="Join Date" id="join_date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="leavestatus" class="col-sm-5 col-form-label"> On Leave </label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="statusyes" name="leavestatus" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="statusyes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="statusno" name="leavestatus" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="statusno">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ctc" class="col-sm-5 col-form-label">CTC</label>
                            <div class="col-sm-7">
                                <input name="ctc" class="form-control" type="text" placeholder="Enter CTC" id="ctc">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ovt" class="col-sm-5 col-form-label">Overtime Price </label>
                            <div class="col-sm-7">
                                <input name="ovt" class="form-control" type="text" placeholder="Enter Overtime Price" id="ovt">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencyContactName" class="col-sm-5 col-form-label">Emergency Contact Name</label>
                            <div class="col-sm-7">
                                <input type="text" name="emergency_contact" placeholder="Emergency Contact Name" id="emergencyContactName" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emergencyContactNumber" class="col-sm-5 col-form-label">Emergency Contact Number</label>
                            <div class="col-sm-7">
                                <input type="text" name="emergency_contact_num" placeholder="Emergency Contact Number" id="emergencyContactName" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emergencyContactRelationship" class="col-sm-5 col-form-label">Emergency Contact Relationship</label>
                            <div class="col-sm-7">
                                <input type="text" name="emergency_contact_rel" placeholder="Emergency Contact Relationship" id="emergencyContactName" class="form-control">
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" id="resetAddDriverForm" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editDriverDetailsModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Driver</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <!-- Default form action with placeholder 0 for driver ID which is changed in function to correct driver ID-->
                <form action="{{route('drivers.update',0)}}" method="post" id="updateDriverDetailsForm" class="row" enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf
                </form>
            </div>

        </div>
        <div class="modal-footer">

        </div>

    </div>

</div>

<!-- Add License Type: -->
<div id="add3" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add License Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('add-license-type')}}" id="add_license_form" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="license_name" class="col-sm-5 col-form-label">License Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="license_name" class="form-control" type="text" placeholder="License Name" id="license_name" required maxlength="50">
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

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Manage Drivers
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Driver
                        </button>&nbsp;
                        <button type="button" class="btn btn-primary btn-md" data-target="#add3" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add License Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="driverinfo" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Driver Name</th>
                                <th>Mobile</th>
                                <th>License Number</th>
                                <th title="National ID">NID</th>
                                <!-- <th>Working Time Slot</th> -->
                                <th>Status</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $driver)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td>
                                    <div class="driver-profile-img-container" style="width: 30%;display: inline-block;">
                                        @if($driver['PROFILE_PHOTO'])
                                        <img src="{{asset('public/upload/profile/drivers/' .$driver['PROFILE_PHOTO'] .'')}}" alt="{{$driver['DRIVER_NAME']}}" style="width: 45px;height: 45px;border-radius:50%">
                                        @else
                                        <img src="{{asset('public/img/default.jpeg')}}" alt="Image" style="width: 45px;height: 45px;border-radius:50%">
                                        @endif
                                    </div>
                                    <div style="width: 60%;display: inline-block;">
                                        {{$driver['DRIVER_NAME']}}
                                    </div>
                                </td>
                                <td> {{$driver['MOBILE_NUMBER']}} </td>
                                <td> {{$driver['LICENSE_NUMBER']}} </td>
                                <td> {{$driver['NATIONAL_ID']}} </td>
                                <!-- <td> {{$driver['WORKING_TIME_START'] . ' - ' . $driver['WORKING_TIME_END'] }} </td> -->
                                <td> @if($driver['IS_ACTIVE'] == 'Y') {{"Active"}} @else {{"Inactive"}} @endif </td>
                                <td>
                                    <button class="btn btn-success mr-1" onclick="updateDriverDetails('{{$driver->DRIVER_ID}}','{{$driver->DRIVER_NAME}}', '{{$driver->MOBILE_NUMBER}}','{{$driver->LICENSE_NUMBER}}','{{$driver->LICENSE_TYPE}}','{{$driver->NATIONAL_ID}}','{{$driver->LICENSE_ISSUE_DATE}}','{{$driver->WORKING_TIME_START}}','{{$driver->WORKING_TIME_END}}','{{$driver->JOIN_DATE}}','{{$driver->DATE_OF_BIRTH}}','{{$driver->PERMANENT_ADDRESS}}','{{$driver->PRESENT_ADDRESS}}','{{$driver->LEAVE_STATUS}}','{{$driver->IS_ACTIVE}}','{{$driver->PROFILE_PHOTO}}','{{$driver->CTC}}','{{$driver->OVT}}')" data-toggle="tooltip" data-placement="right" title="Update">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($driver['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger" title="Deactivate" data-toggle="tooltip" data-placement="left" onclick="deactivateDriver(this)" data-driverid="{{$driver->DRIVER_ID}}">
                                        <i class="ti-close"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-danger" title="Activate" data-toggle="tooltip" data-placement="left" onclick="activateDriver(this)" data-driverid="{{$driver->DRIVER_ID}}">
                                        <i class="ti-reload"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js-content')
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/driver_view.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->

<script>
    // URLs and CSRF Token for AJAX Requests
    let deactivateDriverURL = "{{url('deactivate-driver')}}";
    let activateDriverURL = "{{url('activate-driver')}}";
    let getDataURL = "{{url('drivers/get-data')}}";
    let csrfToken = "{{csrf_token()}}";

    let defaultProfileImgPath = "{{asset('public/img/')}}";
    let driverProfileImgPath = "{{asset('public/upload/profile/drivers/')}}";

    let licenseTypes = JSON.parse(`{!! json_encode($licenseTypes) !!}`);
</script>
<!-- <script src="{{asset('public/dist/js/position_form.js')}}"></script> -->
<script src="{{asset('public/dist/js/drivers/index.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#driverinfo").DataTable();
    });

    $('.date-picker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: 1901,
        maxDate: moment().format('YYYY-MM-DD'),
        drops: "down",
        locale: {
            format: 'YYYY-MM-DD'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function(start, end, label) {
        var years = moment().diff(start, 'years');
    });
    $('.date-picker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });
    $('.date-picker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
</script>
@endsection