@extends('layouts.main.app')

@section('title', 'Fuel Rate Log')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Refueling</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Refueling</h1>
<small id="controllerName">Fuel Rate Log</small>
@endsection

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

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Fuel Rate
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterFuelType" class="col-sm-5 col-form-label justify-content-start text-left">
                                Fuel Type
                            </label>
                            <div class="col-sm-7">
                                <select name="filter_fuel_type" id="filterFuelType" class="form-control basic-single w-100">
                                    <option value="">Please Select</option>
                                    @foreach($fuelTypes as $fuelType)
                                    <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterDateFrom" class="col-sm-5 col-form-label">
                                Date From
                            </label>
                            <div class="col-sm-7">
                                <input type="text" name="filter_date_from" class="form-control" id="filterDateFrom" placeholder="Date From" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterDateTo" class="col-sm-5 col-form-label">
                                Date Till
                            </label>
                            <div class="col-sm-7">
                                <input type="text" name="filter_date_to" class="form-control" id="filterDateTo" placeholder="Date Till" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 text-right">
                        <button type="reset" class="btn btn-inverse mr-2" id="resetFiltersBtn">Reset</button>
                        <button type="submit" class="btn btn-success" id="applyFiltersBtn">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BEGIN DataTable Wrapper --}}
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Fuel Rate Log</h4>
            </div>
            <div class="card-body">
                <div id="table-loader"></div>
                <div class="table-responsive">
                    <table id="fuelRateLogTable" class="table table-bordered table-striped dt-responsive no-wrap">
                        <thead>
                            <th>SL No.</th>
                            <th>Fuel Type</th>
                            <th>Date</th>
                            <th>Rate per Unit (INR)</th>
                            <th>Action(s)</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- END DataTable Wrapper --}}

</div>

{{-- Modal to Add New Fuel Rate Details --}}
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add New Fuel Rate</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addFuelRateForm" action="{{route('fuel-rate-log.add')}}" method="post" class="row" accept-charset="utf-8">
                    @csrf
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group row">
                            <label for="fuelRateDateFrom" class="col-form-label col-sm-5">Date From <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input type="text" name="date_from" class="form-control" id="fuelRateDateFrom" placeholder="Date From">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuelRateDateTill" class="col-form-label col-sm-5">End Date </label>
                            <div class="col-sm-7">
                                <input type="text" name="date_to" class="form-control" id="fuelRateDateTill" placeholder="Date Till">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group row">
                            <label for="FuelTypeForRate" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="fuel_type" id="FuelTypeForRate" class="form-control basic-single">
                                    <option value="">Please Select</option>
                                    @foreach($fuelTypes as $fuelType)
                                    <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuelRate" class="col-sm-5 col-form-label">Rate per Unit (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="number" name="fuel_rate" id="fuelRate" class="form-control" placeholder="Enter Rate">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 text-right">
                        <button type="reset" class="btn btn-primary mr-2" id="clearAddFormBtn">Clear</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal to Edit Fuel Rate Details --}}
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Fuel Rate Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('fuel-rate-log.update')}}" id="updateFuelRateForm" method="post" class="row" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="log_id" id="updateFuelRateId" value="">
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group row">
                            <label for="updateFuelRateDateFrom" class="col-form-label col-sm-5">Date From <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input type="text" name="date_from" class="form-control" id="updateFuelRateDateFrom" placeholder="Date From">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="updateFuelRateDateTill" class="col-form-label col-sm-5">End Date </label>
                            <div class="col-sm-7">
                                <input type="text" name="date_to" class="form-control" id="updateFuelRateDateTill" placeholder="Date Till">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group row">
                            <label for="updateFuelTypeForRate" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="fuel_type" id="updateFuelTypeForRate" class="form-control basic-single">
                                    <option value="">Please Select</option>
                                    @foreach($fuelTypes as $fuelType)
                                    <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="updateFuelRate" class="col-sm-5 col-form-label">Rate per Unit (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="number" name="fuel_rate" id="updateFuelRate" class="form-control" placeholder="Enter Rate">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="custom-loader"></div>
@endsection

@section('js-content')
<script>
    const csrfToken = $('meta[name=csrf-token]').attr('content');
    const listURL = "{{route('fuel-rate-log.list')}}";
    const addURL = "{{route('fuel-rate-log.add')}}";
    const getDetailsURL = "{{route('fuel-rate-log.get-details')}}";
    const activationChangeURL = "{{route('fuel-rate-log.change-activation')}}";
</script>
<script src="{{asset('public/dist/js/refueling/rate_log.js')}}"></script>
@endsection