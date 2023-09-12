@extends('layouts.main.app')

@section('title', 'Refueling Setting')

@section('css-content')
<style>
    div.error {
        font-size: .8em;
        color: #f66;
    }


    select.error~.select2 .select2-selection {
        border: 1px solid #f99;
    }

    #table-loader {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 6px solid #eee;
        border-top-color: #28a745;
        animation: rotate 1s infinite;
        position: absolute;
        /* top: 20%; */
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
<li class="breadcrumb-item active" id="moduleName">Refueling</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Refueling</h1>
<small id="controllerName">Refueling Setting</small>
@endsection

@section('content')
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Refuel Setting</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('refuel-setting.add')}}" id="addRefuelSettingForm" enctype="multipart/form-data" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vehicle" id="vehicle_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_type" id="fuel_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($fuelTypes as $fuelType)
                                    <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dateofrefuel" class="col-sm-5 col-form-label">Refueled Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="refueling_date" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Refueled Date" id="dateofrefuel">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="station_name" class="col-sm-5 col-form-label">Station Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_station" id="station_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($fuelStations as $fuelStation)
                                    <option value="{{$fuelStation['FUEL_STATION_ID']}}">{{$fuelStation['VENDOR_NAME'] . " " . $fuelStation['FUEL_STATION_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="budgetgiven" class="col-sm-5 col-form-label">Budget Given <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="budget_given" required class="form-control" type="number" placeholder="Budget Given" id="budgetgiven">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="place" class="col-sm-5 col-form-label">Place <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="place" required class="form-control" type="text" placeholder="Place" id="place">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kilometer_per_unit" class="col-sm-5 col-form-label">Kilometer Per Unit <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="kilometer_per_unit" required class="form-control" type="number" placeholder="Kilometer Per Unit" id="kilometer_per_unit">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_reading" class="col-sm-5 col-form-label">Last Reading </label>
                            <div class="col-sm-7">
                                <input name="last_reading" class="form-control" type="number" placeholder="Last Reading" id="last_reading">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_unit" class="col-sm-5 col-form-label">Last Unit </label>
                            <div class="col-sm-7">
                                <input name="last_unit" class="form-control" type="number" placeholder="Last Unit" id="last_unit">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="driver_name" class="col-sm-5 col-form-label">Driver Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="driver" id="driver_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="driver_mobile" class="col-sm-5 col-form-label">Driver Mobile <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="driver_mobile" class="form-control" required type="number" placeholder="Driver Mobile" id="driver_mobile">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="refuel_limit_type" class="col-sm-5 col-form-label">Refuel Limit Type </label>
                            <div class="col-sm-7">
                                <input name="refuel_limit_type" class="form-control" type="text" placeholder="Refuel Limit Type" id="refuel_limit_type">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="max_unit" class="col-sm-5 col-form-label">Max Unit <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="max_unit" required class="form-control" type="number" placeholder="Max Unit" id="max_unit">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consumption_percent" class="col-sm-5 col-form-label">Consumption Percent </label>
                            <div class="col-sm-7">
                                <input name="consumption_percent" class="form-control" type="number" placeholder="Consumption Percent" id="consumption_percent">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="odometer_km_after_day_end_stop" class="col-sm-5 col-form-label">Odometer KM after day end stop </label>
                            <div class="col-sm-7">
                                <input name="odometer_after_day_end" class="form-control" type="number" placeholder="Odometer KM after day end stop" id="odometer_km_after_day_end_stop">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="odometer_at_time_of_refueling" class="col-sm-5 col-form-label">Odometer at time of refueling </label>
                            <div class="col-sm-7">
                                <input name="odometer_at_refueling" class="form-control" type="number" placeholder="Odometer at time of refueling" id="odometer_at_time_of_refueling">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit_taken" class="col-sm-5 col-form-label">Unit Taken <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="unit_taken" class="form-control" type="number" placeholder="Unit Taken" id="unit_taken">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="picture" class="col-sm-5 col-form-label">Fuel Slip Scan Copy </label>
                            <div class="col-sm-7">
                                <input type="file" accept="image/*" name="picture">
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label for="" class="col-sm-5 col-form-label">&nbsp; </label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="strict_consumption" value="1">
                                <label for="checkbox2">Strict Consumption Apply</label>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddRefuelSettingForm">Reset</button>
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
                <strong>Update Refuel Setting</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">

            </div>

        </div>

    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Refueling Setting
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Refuel Setting
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="refuelSettingTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Vehicle Name</th>
                                <th>Last Reading</th>
                                <th>Consumption</th>
                                <th>Strict Policy</th>
                                <th>Driver Mobile</th>
                                <th>Fuel Type</th>
                                <th>Refuel Limit</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>1</td>
                                <td>Test Express 1</td>
                                <td>0</td>
                                <td>0</td>
                                <td>No</td>
                                <td>0301234567</td>
                                <td>Diesel</td>
                                <td></td>
                                <td>
                                    <input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelfrm" />
                                    <a onclick="editinfo(10)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuel/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Test Express 2</td>
                                <td>0</td>
                                <td>0</td>
                                <td>No</td>
                                <td>03091234567</td>
                                <td>Diesel</td>
                                <td></td>
                                <td>
                                    <input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelfrm" />
                                    <a onclick="editinfo(9)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuel/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-content')
<script>
    // To store global variables, Route URLs, etc.
    let csrfToken = "{{csrf_token()}}";
    // To load all refuel settings to Data Table:
    let refuelSettingListURL = "{{route('refuel-setting.list')}}";
    // To add a new refuel setting to the DB
    let addRefuelSettingURL = "{{route('refuel-setting.add')}}";
    // To load update form pre-filled with current details of the refuel setting:
    let refuelSettingEditURL = "{{route('refuel-setting.edit')}}";
    // To update refuel setting details after form submission:
    let refuelSettingUpdateURL = "{{route('refuel-setting.update')}}";
    let activationStatusChangeURL = "{{route('refuel-setting.change-activation')}}";
</script>
<!-- <script src="{{asset('dist/js/refuel_setting.js')}}"></script> -->
<script src="{{asset('public/dist/js/refueling/refuel_setting.js')}}"></script>
@endsection