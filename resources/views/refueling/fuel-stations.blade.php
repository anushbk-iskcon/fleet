@extends('layouts.main.app')

@section('title', 'Fuel Stations')

@section('css-content')
<style>
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
<small id="controllerName">Fuel Stations</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Fuel Station</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('fuel-stations.add')}}" id="addFuelStationForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="req_for" class="col-sm-5 col-form-label">Vendor Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <!-- <select class="form-control basic-single" required name="vendor_name" id="vendor_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Auto Parts">Auto Parts </option>
                                    <option value="honda">honda </option>
                                    <option value="asdfas">asdfas </option>
                                </select> -->
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Vendor Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="station_name" class="col-sm-5 col-form-label">Station Name </label>
                            <div class="col-sm-7">
                                <input name="station_name" class="form-control" type="text" placeholder="Station Name" id="station_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="station_code" class="col-sm-5 col-form-label">Station Code <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="station_code" required class="form-control" type="text" placeholder="Station Code" id="station_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="advance_amount" class="col-sm-5 col-form-label">Advance Amount (INR) </label>
                            <div class="col-sm-7">
                                <input name="advance_amount" class="form-control" type="number" placeholder="Advance Amount" id="advance_amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="fuel_type" required class="form-control" id="fuel_type">
                                    <option value="">Please Select</option>
                                    @foreach($fuelTypes as $fuelType)
                                    <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="authorize_person" class="col-sm-5 col-form-label">Authorized Person <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input name="authorize_person" required class="form-control" type="text" placeholder="Authorized Person" id="authorize_person">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contact_num" class="col-sm-5 col-form-label">Contact Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="contact_num" required class="form-control" type="number" placeholder="Contact Number" id="contact_num">
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label for="milage_traking" class="col-sm-5 col-form-label">&nbsp; </label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="is_authorized">
                                <label for="checkbox2">Is Authorized</label>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddFormBtn">Reset</button>
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
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Fuel Station
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="station_namesr" class="col-sm-4 col-form-label justify-content-start text-left">Station Name </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="station_namesr" id="station_namesr" placeholder="Fuel Station">
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="vendorsr" class="col-sm-3 col-form-label justify-content-start text-left">Vendor</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="vendorsr" id="vendorsr" placeholder="Vendor Name">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <div class="col-sm-7 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Update Fuel Station</strong>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body editinfo">
                    <form action="{{route('fuel-stations.update')}}" id="editFuelStationForm" class="row" method="post" accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="fuel_station_id" id="editFuelStationId">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group row">
                                <label for="new_vendor_name" class="col-sm-5 col-form-label">Vendor Name <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <!-- <select class="form-control basic-single" required name="vendor_name" id="vendor_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Auto Parts">Auto Parts </option>
                                    <option value="honda">honda </option>
                                    <option value="asdfas">asdfas </option>
                                </select> -->
                                    <input type="text" class="form-control" name="vendor_name" id="new_vendor_name" placeholder="Vendor Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_station_name" class="col-sm-5 col-form-label">Station Name </label>
                                <div class="col-sm-7">
                                    <input name="station_name" class="form-control" type="text" placeholder="Station Name" id="new_station_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_station_code" class="col-sm-5 col-form-label">Station Code <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="station_code" required class="form-control" type="text" placeholder="Station Code" id="new_station_code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_adv_amt" class="col-sm-5 col-form-label">Advance Amount (INR)</label>
                                <div class="col-sm-7">
                                    <input name="advance_amount" class="form-control" type="number" placeholder="Advance Amount" id="new_adv_amt">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="fuel_type" required class="form-control" id="new_fuel_type">
                                        <option value="">Please Select</option>
                                        @foreach($fuelTypes as $fuelType)
                                        <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group row">
                                <label for="authorize_person" class="col-sm-5 col-form-label">Authorized Person <i class="text-danger">*</i> </label>
                                <div class="col-sm-7">
                                    <input name="authorize_person" required class="form-control" type="text" placeholder="Authorized Person" id="new_authorize_person">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contact_num" class="col-sm-5 col-form-label">Contact Number <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="contact_num" required class="form-control" type="number" placeholder="Contact Number" id="new_contact_num">
                                </div>
                            </div>
                            <div class="form-group row m-0">
                                <label for="milage_traking" class="col-sm-5 col-form-label">&nbsp; </label>
                                <div class="col-sm-7 checkbox checkbox-primary">
                                    <input id="checkbox2" type="checkbox" name="is_authorized">
                                    <label for="checkbox2">Is Authorized</label>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditFormBtn">Reset</button>
                                <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Manage Fuel Stations </h4>
            </div>
            <div class="card-body">
                <div id="table-loader"></div>
                <div class="table-responsive">
                    <table id="stationinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Station Name</th>
                                <th>Vendor Name</th>
                                <th>Authorized Person</th>
                                <th>Contact Number</th>
                                <th>Is Authorized</th>
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
@endsection

@section('js-content')
<!-- <script src="{{asset('dist/js/fuelstation_list.js')}}"></script> -->
<script>
    let csrfToken = '{{csrf_token()}}';
    let getFuelStationDetailsURL = '{{route("fuel-stations.get-details")}}';
    let fuelStationsListURL = '{{route("fuel-stations.list")}}';
    let updateActivationStatusURL = "{{ route('fuel-stations.update-status') }}";
</script>
<script src="{{asset('public/dist/js/refueling/fuel_stations.js')}}">
</script>

@endsection