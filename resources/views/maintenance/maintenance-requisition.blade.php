@extends('layouts.main.app')

@section('title', 'Maintenance Requisitions')

@section('css-content')
<style>
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
<li class="breadcrumb-item active" id="moduleName">Maintenance</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Maintenance</h1>
<small id="controllerName">Maintenance Requisitions</small>
@endsection

@section('content')

<div id="viewInfo" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Details</strong>
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
                    Search Here
                    <small class="float-right">
                        <a href="{{route('add-maintenance-list')}}" class="btn btn-primary btn-md">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Requisition
                        </a>
                    </small>
                </h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="mainten_type" class="col-sm-5 col-form-label justify-content-start text-left">Maintenance Type </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="mainten_type" id="mainten_type">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($maintenanceTypes as $maintenanceType)
                                <option value="{{$maintenanceType['MAINTENANCE_ID']}}">{{$maintenanceType['MAINTENANCE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="vehicle" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehicle" id="vehicle">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME'] . ' (' . $vehicle['LICENSE_PLATE'] . ')'}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($statuses as $status)
                                <option value="{{$status['PHASE_ID']}}">{{$status['PHASE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="service_fr" class="col-sm-5 col-form-label justify-content-start text-left">Maintenance Service</label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="mainten_service" id="service_fr">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($maintenanceServices as $maintenanceService)
                                <option value="{{$maintenanceService['MAINTENANCE_SERVICE_ID']}}">{{$maintenanceService['MAINTENANCE_SERVICE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="filter_from" class="col-sm-5 col-form-label justify-content-start text-left">From </label>
                        <div class="col-sm-7">
                            <input name="from" autocomplete="off" class="form-control new-datepicker" type="text" placeholder="From" id="filter_from" value="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="filter_to" class="col-sm-5 col-form-label justify-content-start text-left">To </label>
                        <div class="col-sm-7">
                            <input name="to" autocomplete="off" class="form-control new-datepicker" type="text" placeholder="To" id="filter_to" value="">
                        </div>
                    </div>
                    <div class="form-group row  mb-1">
                        <label for="joining_d_to" class="col-sm-5 col-form-label justify-content-start text-left">&nbsp;</label>
                        <div class="col-sm-7 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Maintenance Requisition List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="mainreq" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Requisition Date</th>
                                <th>Vehicle</th>
                                <th>Maintenance Type</th>
                                <th>Requested By </th>
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/maintainrequisition_list.js"></script> -->
@if(session('message'))
<script>
    toastr.success('{{session("message")}}', '', {
        closeButton: true
    });
</script>
@endif
<script>
    // For storing routes and other global variables
    let getRequisitionsDataURL = "{{route('maintenance-requisitions.list')}}";
    let editRequisitionPlaceholderURL = "{{route('maintenance-requisitions.edit', ['requisition'=>'0'])}}"; // 0 in URL is replaced by ID in script
    let getRequisitionDetailsURL = "{{route('maintenance-requisitions.get-details')}}";
    let csrfToken = "{{csrf_token()}}";
    let updateApprovalStatusURL = "{{route('maintenance-requisitions.change-approval-status')}}";

    let currentYear = moment().year();
</script>
<script src="{{asset('public/dist/js/maintenance/mainten_req_list.js')}}">
</script>
@endsection