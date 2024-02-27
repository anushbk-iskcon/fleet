@extends('layouts.main.app')

@section('title', 'Transactions')

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
<li class="breadcrumb-item active" id="moduleName">Transactions</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Transactions</h1>
<small id="controllerName">Transaction List</small>
@endsection

@section('content')
<!-- Modal to add new transaction details -->
<div id="add" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Transaction Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('transactions.add')}}" id="addTransactionForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group row">
                                <label for="transactionType" class="col-sm-5 col-form-label">Transaction Type <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="transaction_type" id="transactionType" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($transactionTypes as $transactionType)
                                        <option value="{{$transactionType['TRANSACTION_TYPE_ID']}}">
                                            {{$transactionType['TRANSACTION_TYPE']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="dept_code" id="dept_code" value="">
                        </div>
                    </div>
                    <div id="addFormAdditionalFields"></div>
                    <div id="addFormButtonsWrapper">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group text-right">
                                    <button type="reset" class="btn btn-primary mr-1">Clear</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal to edit details of a given transaction -->
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Transaction Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('transactions.update')}}" method="post" id="updateTransactionForm" enctype="multipart/form-data" accept-charset="utf-8"></form>
            </div>
        </div>
    </div>
</div>

<!-- Search / Filter -->
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button class="btn btn-primary btn-md" data-target="#add" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Transaction
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form action="" id="filterForm" class="row">
                    @csrf
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-1">
                            <label for="filterTransactionType" class="col-sm-5 col-form-label text-left">Type</label>
                            <div class="col-sm-7">
                                <select name="filter_transaction_type" id="filterTransactionType" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach($transactionTypes as $transactionType)
                                    <option value="{{$transactionType['TRANSACTION_TYPE_ID']}}">
                                        {{$transactionType['TRANSACTION_TYPE']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-1">
                            <label for="filterTransactionDateFrom" class="col-sm-5 col-form-label text-left">Bill Date From</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="filterTransactionDateFrom" name="filter_date_from" placeholder="Date From" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-1">
                            <label for="filterTransactionDateTo" class="col-sm-5 col-form-label text-left">Bill Date Till</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="filterTransactionDateTo" name="filter_date_to" placeholder="Date To" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mb-1 mt-2">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success w-md m-b-5" id="btn-filter">Submit</button>
                                <button type="reset" class="btn btn-danger w-md m-b-5" id="btn-reset">Reset</button>
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
                <h4 class="pl-3">
                    Transactions
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="transactionTable" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Type</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Vehicle</th>
                                <th>Amount</th>
                                <th>Devotee Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="custom-loader"></div>

@endsection

@section('js-content')
<script>
    const csrfToken = $('meta[name=csrf-token]').attr('content');

    // Master data passed as Laravel collection to convert to JSON format
    const drivers = JSON.parse(`{!! json_encode($drivers) !!}`);
    const vehicles = JSON.parse(`{!! json_encode($vehicles) !!}`);
    const vehicleTypes = JSON.parse(`{!! json_encode($vehicleTypes) !!}`);
    const departments = JSON.parse(`{!! json_encode($departments['data']) !!}`);
    const transactionTypes = JSON.parse(`{!! json_encode($transactionTypes) !!}`);

    // File Path to View Uploaded Documents
    const uploadedFilePath = '{{asset("public/upload/documents/transactions/")}}';

    // To use Laravel Routes in custom scripts
    const listURL = '{{route("transactions.list")}}';
    const getDetailsURL = '{{route("transactions.get-details")}}';
    const updateURL = '{{route("transactions.update")}}';
</script>
<script src="{{asset('public/dist/js/transactions/transactions.js')}}"></script>
@endsection