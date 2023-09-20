@extends('layouts.main.app')

@section('title','Manage Transactions')

@section('css-content')
<style>
    div.error {
        font-size: .8em;
        color: #f66;
    }

    select.error~.select2 .select2-selection {
        border: 1px solid #f99;
    }

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
<li class="breadcrumb-item active" id="moduleName">Driver Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Driver Management</h1>
<small id="controllerName">Manage Transactions</small>
@endsection

@section('content')

<!-- Modal for adding new overtime/ transaction details -->
<div id="add0" class="modal fade bd-examplemodal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Transaction Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addTransactionDetailsForm" action="{{route('driver-transaction.add')}}" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="transactionDate" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="transaction_date" class="form-control newdatetimepicker" id="transactionDate" placeholder="Date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transactionForDriver" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="driver" id="transactionForDriver" class="form-control basic-single">
                                    <option value="">Please Select Driver</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transactionPurpose" class="col-sm-5 col-form-label">Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="purpose" id="transactionPurpose" class="form-control">
                                    <option value="">Please Select Purpose</option>
                                    <option value="1">Over Time</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="durationForOvertime" class="col-form-label col-md-5">Duration (in minutes) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="durationForOvertime" name="duration" placeholder="Enter duration">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transactionAmt" class="col-md-5 col-form-label">Amount (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="transactionAmt" name="amount" placeholder="Amount">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" id="resetAddFormBtn" class="btn btn-primary w-md m-b-5">Clear</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal for Adding Details -->

<!-- Modal for editing transaction details -->
<div id="edit" class="modal fade bd-examplemodal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Edit Transaction Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateTransactionDetailsForm" action="{{route('driver-transaction.update')}}" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="transaction_id" id="editTransactionId" value="">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="editTransactionDate" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="transaction_date" class="form-control newdatetimepicker" id="editTransactionDate" placeholder="Date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editTransactionForDriver" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="driver" id="editTransactionForDriver" class="form-control basic-single">
                                    <option value="">Please Select Driver</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editTransactionPurpose" class="col-sm-5 col-form-label">Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="purpose" id="editTransactionPurpose" class="form-control">
                                    <option value="">Please Select Purpose</option>
                                    <option value="1">Over Time</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="editDurationForOvertime" class="col-form-label col-md-5">Duration (in minutes) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editDurationForOvertime" name="duration" placeholder="Enter duration">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editTransactionAmt" class="col-md-5 col-form-label">Amount (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="editTransactionAmt" name="amount" placeholder="Amount">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" id="resetUpdateFormBtn" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Modal for Editing Details -->

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal" title="Add">
                            <i class="fas fa-plus"></i>
                        </button>
                        <!-- <button class="btn btn-primary btn-md" title="Filter" id="filterBtn">
                            <i class="fas fa-filter"></i>
                        </button> -->
                    </small>
                </h4>
            </div>

            <div class="card-body">
                <div id="filterFormContainer" class="row">
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-1">
                            <label for="filter_driver" class="col-sm-4 col-form-label justify-content-start text-left">
                                Driver
                            </label>
                            <div class="col-sm-8">
                                <select name="driver_sr" id="filter_driver" class="form-control basic-single">
                                    <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-1">
                            <label for="filter_date" class="col-sm-4 col-form-label justify-content-start text-left">
                                Date
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="date_sr" class="form-control newdatetimepicker" id="filter_date" placeholder="Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-1">
                            <label for="filterPurpose" class="col-sm-4 col-form-label justify-content-start text-left">
                                Purpose
                            </label>
                            <div class="col-sm-8">
                                <select name="purpose_sr" id="filterPurpose" class="form-control">
                                    <option value="">Select Purpose</option>
                                    <option value="1">Over Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1 mt-2">
                            <div class="col-sm-12 text-right">
                                <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                                <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Transaction Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="driverTransactionsTable" class="table table-striped table-bordered dataTable dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Date</th>
                                <th>Driver</th>
                                <th>Purpose</th>
                                <th>Duration (minutes)</th>
                                <th>Amount (INR)</th>
                                <th>Date Recorded</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="customloader"></div>
@endsection

@section('js-content')
<script>
    let transactionsListURL = '{{route("driver-transaction.list")}}';
    let transactionDetailsURL = '{{route("driver-transaction.details")}}';
    let transactionDetailsUpdateURL = '{{route("driver-transaction.update")}}';
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
</script>
<script src="{{asset('public/dist/js/drivers/transactions.js')}}"></script>
@endsection