@extends('layouts.main.app')

@section('title', 'Fuel Stations')

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
                            <label for="authorize_person" class="col-sm-5 col-form-label">Authorize Person <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input name="authorize_person" required class="form-control" type="text" placeholder="Authorize Person" id="authorize_person">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
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
                                <label for="checkbox2">Is Authorize</label>
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
                            <select class="form-control basic-single" name="station_namesr" id="station_namesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="GM Filling Station">GM Filling Station </option>
                                <option value="Khalek filling Station">Khalek filling Station </option>
                                <option value="cvbc"> cvbc </option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="vendorsr" class="col-sm-4 col-form-label justify-content-start text-left">Vendor <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <select class="form-control basic-single" name="vendorsr" id="vendorsr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Auto Parts">Auto Parts </option>
                                <option value="honda">honda </option>
                                <option value="asdfas">asdfas </option>
                            </select>
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
                    <form action="" id="editFuelStationForm" class="row" method="post" accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="fuel_station_id" id="editFuelStationId">
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
                                    <input type="text" class="form-control" name="vendor_name" id="new_vendor_name" placeholder="Vendor Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="station_name" class="col-sm-5 col-form-label">Station Name </label>
                                <div class="col-sm-7">
                                    <input name="station_name" class="form-control" type="text" placeholder="Station Name" id="new_station_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="station_code" class="col-sm-5 col-form-label">Station Code <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="station_code" required class="form-control" type="text" placeholder="Station Code" id="new_station_code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="authorize_person" class="col-sm-5 col-form-label">Authorize Person <i class="text-danger">*</i> </label>
                                <div class="col-sm-7">
                                    <input name="authorize_person" required class="form-control" type="text" placeholder="Authorize Person" id="new_authorize_person">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
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
                                    <label for="checkbox2">Is Authorize</label>
                                </div>
                            </div>
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
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Manage Fuel Station </h4>
            </div>
            <div class="card-body">
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

                            @foreach($fuelStations as $fuelStation)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$fuelStation['FUEL_STATION_NAME']}}</td>
                                <td>{{$fuelStation['VENDOR_NAME']}}</td>
                                <td>{{$fuelStation['AUTHORIZE_PERSON']}}</td>
                                <td>{{$fuelStation['CONTACT_NUMBER']}}</td>
                                <td>@if($fuelStation['IS_AUTHORIZED'] == 'Y') {{"Yes"}} @else {{"No"}} @endif</td>
                                <td>
                                    <button type="button" class="btn btn-info mr-1" title="Edit" data-id="{{$fuelStation['FUEL_STATION_ID']}}" onclick="editInfo(this, '{{$fuelStation['FUEL_STATION_NAME']}}')"><i class="ti-pencil"></i></button>
                                    @if($fuelStation['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="{{$fuelStation['FUEL_STATION_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success mr-1" title="Activate" data-id="{{$fuelStation['FUEL_STATION_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            <!-- <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>GM Filling Station</td>
                                <td>Honda</td>
                                <td>Jaman</td>
                                <td>0172345600</td>
                                <td>Yes</td>
                                <td style=""><input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelstfrm"><a onclick="editinfo(1)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelst/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Khalek filling Station</td>
                                <td>Auto Parts</td>
                                <td>Khalek</td>
                                <td>01723456001</td>
                                <td>No</td>
                                <td style=""><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelstfrm"><a onclick="editinfo(2)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelst/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td> cvbc</td>
                                <td>vandor</td>
                                <td>rtytryrtyyy</td>
                                <td>464564654</td>
                                <td>No</td>
                                <td style=""><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelstfrm"><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelst/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
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
<!-- <script src="{{asset('dist/js/fuelstation_list.js')}}"></script> -->
<script>
    let csrfToken = '{{csrf_token()}}';
    let getFuelStationDetailsURl = '{{route("fuel-stations.get-details")}}';
</script>
<script src="{{asset('dist/js/refueling/fuel-stations.js')}}">
</script>

@endsection