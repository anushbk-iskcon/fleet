@extends('layouts.main.app')

@section('title', 'FC/Road Tax/Permit Charges')

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
        right: 50%;
        z-index: 2;
        display: none;
    }

    .custom-loader {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 3px solid #ddd;
        border-top-color: #28a745;
        animation: rotate 1s infinite;
        position: fixed;
        top: 33%;
        right: 56%;
        display: none;
        z-index: 9999;
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
<li class="breadcrumb-item active" id="moduleName">Charges (FC/Road Tax/Permit)</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Charges (FC/Road Tax/Permit)</h1>
<small id="controllerName">Charges List</small>
@endsection

@section('content')
<!-- Modal to Add Details -->
<div id="add" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Charge Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('charges.add')}}" id="addChargeForm" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group row">
                                <label for="addChargeType" class="col-sm-5 col-form-label">
                                    Charge For <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-7">
                                    <select name="charge_type" id="addChargeType" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1">FC</option>
                                        <option value="2">Road Tax</option>
                                        <option value="3">Permit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="addFormAdditionalFields"></div>
                    <div id="addFormBtnsWrapper">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group text-right">
                                    <button type="reset" class="btn btn-primary mr-1" id="clearAddFormBtn">Clear</button>
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Edit Details -->
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Charge Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('charges.update')}}" id="editChargeForm" method="post" accept-charset="utf-8"></form>
            </div>
        </div>
    </div>
</div>

<!-- Search/Filter -->
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button class="btn btn-primary btn-md" data-target="#add" data-toggle="modal">
                            <i class="ti-plus"></i>
                            Add Charge
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form action="" class="row" id="filterForm" method="post">
                    @csrf
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterChargeType" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-8">
                                <select name="filter_charge_type" id="filterChargeType" class="form-control basic-single">
                                    <option value="">Please Select</option>
                                    <option value="1">FC</option>
                                    <option value="2">Road Tax</option>
                                    <option value="3">Permit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="filterVehicle" class="col-sm-3 col-form-label">Vehicle</label>
                            <div class="col-sm-9">
                                <select name="filter_vehicle" id="filterVehicle" class="form-control basic-single">
                                    <option value="">Please Select</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">
                                        {{$vehicle['VEHICLE_NAME'] . ' (' . $vehicle['LICENSE_PLATE'] . ')'}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterDateFrom" class="col-sm-5 col-form-label">Date From</label>
                            <div class="col-sm-7">
                                <input type="text" name="filter_date_from" id="filterDateFrom" class="form-control" placeholder="Date From">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterDateTill" class="col-sm-5 col-form-label">Date Till</label>
                            <div class="col-sm-7">
                                <input type="text" name="filter_date_till" id="filterDateTill" class="form-control" placeholder="Date Till">
                            </div>
                        </div>
                        <div class="form-group row mb-1 mt-2">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success w-md mr-2" id="btn-filter">Submit</button>
                                <button type="reset" class="btn btn-danger w-md mr-2" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DataTable -->
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Charges</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="chargesTable" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Charge Type</th>
                                <th>Vehicle</th>
                                <th>Challan No.</th>
                                <th>Starts From</th>
                                <th>Expires On</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DataTable -->

<div class="custom-loader"></div>
@endsection

@section('js-content')
<script>
    const csrfToken = '{{csrf_token()}}';

    // To convert Laravel objects for use in script
    const vehicleTypes = JSON.parse(`{!! json_encode($vehicleTypes) !!}`);

    const filteredVehiclesListURL = "{{route('charges.get-filtered-vehicles')}}";
    const listURL = "{{route('charges.list')}}";
    const addChargeURL = "{{route('charges.add')}}";
    const getChargeDetailsURL = "{{route('charges.details')}}";
    const updateChargeURL = "{{route('charges.update')}}";
</script>
<script src="{{asset('public/dist/js/charges/charges.js')}}"></script>
@endsection