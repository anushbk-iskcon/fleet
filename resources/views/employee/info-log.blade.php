@extends('layouts.main.app')

@section('title', 'Driver Log')

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
<small id="controllerName"> Information Log </small>
@endsection

@section('content')
<!--  Begin: Modal to Add New Log Entry Details -->
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Driver Log</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="addLogForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<!--  End: Modal to Add New Log Entry Details -->

<!-- Begin: Modal to Edit Log Entry Details -->
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog"></div>
<!-- End: Modal to Edit Log Entry Details -->

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Log
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form action="" method="post" id="filterLogsForm" class="row">
                    @csrf
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="filterDriver" class="col-sm-4 col-form-label justify-content-start text-left">
                                Driver
                            </label>
                            <div class="col-sm-8">
                                <select name="driver_sr" id="filterDriver" class="form-control">
                                    <option value="">Please Select</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="filterDate" class="col-sm-4 col-form-label justify-content-start text-left">
                                Date
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="date_sr" class="form-control" id="filterDate" placeholder="Select Date" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="filterLogCategory" class="col-sm-4 col-form-label justify-content-start text-left">
                                Category
                            </label>
                            <div class="col-sm-8">
                                <select name="log_categ_sr" id="filterLogCategory" class="form-control">
                                    <option value="">Please Select</option>
                                    {{-- Add options for category--}}
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-2 mb-1">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                                <button type="reset" class="btn btn-inverse" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Driver Log Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="logInfoTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Driver</th>
                                <th>Category</th>
                                <th>Remarks</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> <!-- ./ table-responsive -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script>
    // Store info like routes etc. into global variables
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
</script>
<script src="{{asset('public/dist/js/drivers/info_log.js')}}"></script>
@endsection