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

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Refueling Requisition </strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="emp_form" class="row" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vehicle_name" id="vehicle_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Shah Latif Express UP">Shah Latif Express UP </option>
                                    <option value="Sukkur Express UP">Sukkur Express UP </option>
                                    <option value="Khyber Express">Khyber Express </option>
                                    <option value="Fareed Express">Fareed Express </option>
                                    <option value="d">d </option>
                                    <option value="AS">AS </option>
                                    <option value="quad r647">quad r647 </option>
                                    <option value="Kia Soul">Kia Soul </option>
                                    <option value="red">red </option>
                                    <option value="Kia">Kia </option>
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
                                    <option value="GM Filling Station">GM Filling Station </option>
                                    <option value="Khalek filling Station">Khalek filling Station </option>
                                    <option value=" cvbc"> cvbc </option>
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
                                    <option value="Diesel">
                                        Diesel</option>
                                    <option value="SP95">
                                        SP95</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="current_odometer" class="col-sm-5 col-form-label">Current Odometer <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="current_odometer" required class="form-control" type="number" placeholder="Current Odometer" id="current_odometer">
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
                <strong>Update Refuel Requisition</strong>
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
<script src="{{asset('dist/js/refueling/refuel_requisition.js')}}">
</script>
@endsection