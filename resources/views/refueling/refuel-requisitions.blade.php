@extends('layouts.main.app')

@section('title', 'Refueling Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Refueling</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Refueling</h1>
<small id="controllerName">Refueling Requisitions</small>
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
</style>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Refueling Requisition </strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('refuel-requisitions.add')}}" id="addRefuelRequisitionForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle_name" id="vehicle_name">
                                    <option value="" selected="selected">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-sm-5 col-form-label">Quantity <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="qty" required class="form-control" type="number" placeholder="Quantity" id="qty">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuel_station" class="col-sm-5 col-form-label">Fuel Station <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_station" id="fuel_station">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($fuelStations as $fuelStation)
                                    <option value="{{$fuelStation['FUEL_STATION_ID']}}">{{$fuelStation['FUEL_STATION_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
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
                            <label for="current_odometer" class="col-sm-5 col-form-label">Current Odometer <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="current_odometer" required class="form-control" type="number" placeholder="Current Odometer" id="current_odometer">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-sm-5 col-form-label">Amount (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="amount" required class="form-control" type="number" placeholder="Amount" id="amount">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddRefuelReqFormBtn">Reset</button>
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
                <strong>Update Refuel Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('refuel-requisitions.update')}}" id="editRefuelRequisitionForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="refuel_req_id" id="editRefuelReqId">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="new_vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle_name" id="new_vehicle_name">
                                    <option value="" selected="selected">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_qty" class="col-sm-5 col-form-label">Quantity <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="qty" required class="form-control" type="number" placeholder="Quantity" id="new_qty">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_fuel_station" class="col-sm-5 col-form-label">Fuel Station <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_station" id="new_fuel_station">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($fuelStations as $fuelStation)
                                    <option value="{{$fuelStation['FUEL_STATION_ID']}}">{{$fuelStation['FUEL_STATION_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="new_fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_type" id="new_fuel_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($fuelTypes as $fuelType)
                                    <option value="{{$fuelType['FUEL_ID']}}">{{$fuelType['FUEL_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_current_odometer" class="col-sm-5 col-form-label">Current Odometer <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="current_odometer" required class="form-control" type="number" placeholder="Current Odometer" id="new_current_odometer">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_amount" class="col-sm-5 col-form-label">Amount (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="amount" required class="form-control" type="number" placeholder="Amount" id="new_amount">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetUpdateRefuelReqFormBtn">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
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
                    Refuel Requisition List
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Refueling Requisition
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="refuel_requests" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Vehicle Name</th>
                                <th>Fuel Type</th>
                                <th>Odometer</th>
                                <th>Quantity</th>
                                <th>Fuel Station</th>
                                <th>Amount</th>
                                <th>Status</th>
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
@endsection

@section('js-content')
<!-- <script src="{{asset('dist/js/refuel_requisition.js')}}"></script> -->
<script>
    let refuelRequisitionsListURL = "{{route('refuel-requisitions.list')}}";
    let addRefuelReqURL = "{{route('refuel-requisitions.add')}}";
    let updateRefuelReqURL = "{{route('refuel-requisitions.update')}}";
    let reqStatusUpdateURL = "{{route('refuel-requisitions.change-status')}}";
    let reqActivationUpdateURL = "{{route('refuel-requisitions.change-activation')}}";
    let getReqDetailsURL = "{{route('refuel-requisitions.get-details')}}";
</script>
<script src="{{asset('public/dist/js/refueling/refuel_requisition.js')}}">
</script>
@endsection