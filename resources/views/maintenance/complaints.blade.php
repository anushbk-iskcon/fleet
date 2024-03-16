@extends('layouts.main.app')

@section('title', 'Complaints')

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
<li class="breadcrumb-item active" id="moduleName">Maintenance</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Maintenance</h1>
<small id="controllerName">Vehicle Complaints</small>
@endsection

@section('content')
<!-- Modal with Form to Add Complaint -->
<div id="add" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Log Complaint</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('complaints.add')}}" method="post" id="addComplaintForm" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="complaintRegister" class="col-sm-5 col-form-label">Complaint Register <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="complaint_register" class="form-control" id="complaintRegister">
                                        <option value="">Please Select</option>
                                        <option value="C">Car Complaint Register</option>
                                        <option value="A">Auto Rickshaw Complaint Register</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jobCardNumber" class="col-sm-5 col-form-label">Job Card Number</label>
                                <div class="col-sm-7">
                                    <input type="text" name="job_card_number" class="form-control" id="jobCardNumber" placeholder="Job Card Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vehicleType" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="complaint_vehicle_type" class="form-control basic-single" id="vehicleType">
                                        <option value="">Please Select</option>
                                        @foreach($vehicleTypes as $vehicleType)
                                        <option value="{{$vehicleType['VEHICLE_TYPE_ID']}}">{{$vehicleType['VEHICLE_TYPE_NAME']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="complaintVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="complaint_vehicle" class="form-control basic-single" id="complaintVehicle">
                                        <option value="">Please Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vehicleModel" class="col-sm-5 col-form-label">Model </label>
                                <div class="col-sm-7">
                                    <input type="text" name="complaint_vehicle_model" class="form-control" id="vehicleModel" placeholder="Model">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kmReading" class="col-sm-5 col-form-label">Odometer Reading</label>
                                <div class="col-sm-7">
                                    <input type="text" name="km_reading" class="form-control" id="kmReading" placeholder="KM Reading">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="complaintDate" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input type="text" name="complaint_date" class="form-control" id="complaintDate" placeholder="Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="complaintDriver" class="col-form-label col-sm-5">Driver <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="driver" id="complaintDriver" class="form-control basic-single">
                                        <option value="">Please Select</option>
                                        @foreach($drivers as $driver)
                                        <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="repairDetails" class="col-sm-5 col-form-label">Repair Details <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input type="text" name="repair_details" class="form-control" id="repairDetails" maxlength="150" placeholder="Repair Details">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="repairStartDate" class="col-sm-5 col-form-label">Date to Start Repair</label>
                                <div class="col-sm-7">
                                    <input type="text" name="repair_start_date" class="form-control" id="repairStartDate" placeholder="Repair Start Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="repairCompletionDate" class="col-sm-5 col-form-label">Date of Completion</label>
                                <div class="col-sm-7">
                                    <input type="text" name="repair_completion_date" class="form-control" id="repairCompletionDate" placeholder="Completion Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="billAmount" class="col-form-label col-sm-5">Bill Amount (INR)</label>
                                <div class="col-sm-7">
                                    <input type="number" name="bill_amount" id="billAmount" class="form-control" placeholder="Bill Amount">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="addFormButtonsWrapper">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="reset" class="btn btn-primary mr-1">Clear</button>
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
<!-- /Add Form Modal -->

<!-- Modal with Form to Edit Complaint -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Complaint</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('complaints.update')}}" method="post" id="updateComplaintForm" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="complaint_id" id="updateComplaintId">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="updateComplaintRegister" class="col-sm-5 col-form-label">Complaint Register <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="complaint_register" class="form-control" id="updateComplaintRegister">
                                        <option value="">Please Select</option>
                                        <option value="C">Car Complaint Register</option>
                                        <option value="A">Auto Rickshaw Complaint Register</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateJobCardNumber" class="col-sm-5 col-form-label">Job Card Number</label>
                                <div class="col-sm-7">
                                    <input type="text" name="job_card_number" class="form-control" id="updateJobCardNumber" placeholder="Job Card Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateVehicleType" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="complaint_vehicle_type" class="form-control basic-single" id="updateVehicleType">
                                        <option value="">Please Select</option>
                                        @foreach($vehicleTypes as $vehicleType)
                                        <option value="{{$vehicleType['VEHICLE_TYPE_ID']}}">{{$vehicleType['VEHICLE_TYPE_NAME']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateComplaintVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="complaint_vehicle" class="form-control basic-single" id="updateComplaintVehicle">
                                        <option value="">Please Select</option>
                                        @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME'] . ' ('. $vehicle['LICENSE_PLATE'] . ')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateVehicleModel" class="col-sm-5 col-form-label">Model </label>
                                <div class="col-sm-7">
                                    <input type="text" name="complaint_vehicle_model" class="form-control" id="updateVehicleModel" placeholder="Model">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateKmReading" class="col-sm-5 col-form-label">Odometer Reading</label>
                                <div class="col-sm-7">
                                    <input type="text" name="km_reading" class="form-control" id="updateKmReading" placeholder="KM Reading">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="updateComplaintDate" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input type="text" name="complaint_date" class="form-control" id="updateComplaintDate" placeholder="Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateComplaintDriver" class="col-form-label col-sm-5">Driver <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="driver" id="updateComplaintDriver" class="form-control basic-single">
                                        <option value="">Please Select</option>
                                        @foreach($drivers as $driver)
                                        <option value="{{$driver['DRIVER_ID']}}">{{$driver['DRIVER_NAME']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateRepairDetails" class="col-sm-5 col-form-label">Repair Details <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input type="text" name="repair_details" class="form-control" id="updateRepairDetails" maxlength="150" placeholder="Repair Details">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateRepairStartDate" class="col-sm-5 col-form-label">Date to Start Repair</label>
                                <div class="col-sm-7">
                                    <input type="text" name="repair_start_date" class="form-control" id="updateRepairStartDate" placeholder="Repair Start Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateRepairCompletionDate" class="col-sm-5 col-form-label">Date of Completion</label>
                                <div class="col-sm-7">
                                    <input type="text" name="repair_completion_date" class="form-control" id="updateRepairCompletionDate" placeholder="Completion Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="updateBillAmount" class="col-form-label col-sm-5">Bill Amount (INR)</label>
                                <div class="col-sm-7">
                                    <input type="number" name="bill_amount" id="updateBillAmount" class="form-control" placeholder="Bill Amount">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="updateFormButtonsWrapper">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /End Modal with Edit Form -->

<!-- Modal to View Complaint Details and Approve/Cancel -->
<div class="modal fade" id="view">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>View Complaint Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="approvalStatus" class="mb-2"></div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Register Book</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="complaintRegisterValue">Car Complaints</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Vehicle</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="vehicleDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Driver Name</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="driverNameDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Type of Vehicle</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="vehicleTypeDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Model</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="vehicleModelDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-2"><strong>KM Reading</strong></div>
                            <div class="col-sm-6 mb-2">
                                <div class="detail-value" id="kmReadingDetail"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Complaint Date:</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="complaintDateDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Job Card Number</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="jobCardNumberDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Repair Details</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="repairDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Date to Start Repair</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="repairStartDateDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Date of Repair Completion</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="repairCompletionDateDetail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3"><strong>Bill Amount</strong></div>
                            <div class="col-sm-6 mb-3">
                                <div class="detail-value" id="billAmountDetail"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <form id="approveForm" action="{{route('complaints.update-approval')}}" method="post">
                            @csrf
                            <input type="hidden" name="complaint_id" id="approveComplaintId">
                            <input type="hidden" name="approval_status" value="A">
                            <button type="submit" id="approveComplaintBtn" class="btn btn-success mr-2" style="display: none;">
                                <i class="fas fa-check mr-1"></i>Approve
                            </button>
                        </form>
                        <form id="cancelForm" action="{{route('complaints.update-approval')}}" method="post">
                            @csrf
                            <input type="hidden" name="complaint_id" id="cancelComplaintId">
                            <input type="hidden" name="approval_status" value="X">
                            <button type="submit" id="cancelComplaintBtn" class="btn btn-danger" style="display: none;">
                                <i class="fas fa-times mr-1"></i>Reject
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /End Modal to View Complaint Details -->

<!-- Modal to Mark Complaint as Completed -->
<div class="modal fade" id="completeComplaint">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Set Complaint as Closed</strong>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('complaints.close-complaint')}}" method="post" id="completeComplaintForm" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="complaint_id" id="complaintIdToClose">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="" class="col-sm-6 col-form-label">Completion Date <i class="text-danger">*</i> </label>
                                <div class="col-sm-6">
                                    <input type="text" name="repair_completion_date" id="complaintCompletionDate" class="form-control" placeholder="Date of Completion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-6 col-form-label">Bill Amount <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input type="number" name="bill_amount" id="complaintCompletionAmount" class="form-control" placeholder="Bill Amount">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Continue</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                            Log Complaint
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form action="" method="post" class="row" id="filterForm">
                    @csrf
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterVehicle" class="col-form-label col-sm-4">Vehicle</label>
                            <div class="col-sm-8">
                                <select name="filter_vehicle" class="form-control basic-single" id="filterVehicle">
                                    <option value="">Please Select</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME'] . ' (' . $vehicle['LICENSE_PLATE'] . ')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterDateFrom" class="col-form-label col-sm-5">Date From</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="filter_date_from" id="filterDateFrom" placeholder="Date From" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group row mb-2">
                            <label for="filterDateTo" class="col-form-label col-sm-5">Date To</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="filter_date_to" id="filterDateTo" placeholder="Date To" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success" id="filter_submit_btn">Search</button>
                                <button type="reset" class="btn btn-inverse" id="filter_reset_btn">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DataTable Wrapper Card -->
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Vehicle Complaints</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="vehicleComplaintsTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Vehicle</th>
                                <th>Vehicle Type</th>
                                <th>Driver</th>
                                <th>Date</th>
                                <th>Status</th>
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
<!-- /DataTable Wrapper Card -->
<div class="custom-loader"></div>
@endsection

@section('js-content')
<script>
    const csrfToken = $('meta[name=csrf-token]').attr('content');
    const filteredVehiclesListURL = "{{route('complaints.vehicle-list')}}";
    const complaintsListURL = "{{route('complaints.list')}}";
    const addComplaintURL = "{{route('complaints.add')}}";
    const getDetailsURL = "{{route('complaints.get-details')}}";
    const viewDetailsURL = "{{route('complaints.view-details')}}";
    const updateComplaintURL = "{{route('complaints.update')}}";
    const closeComplaintURL = "{{route('complaints.close-complaint')}}";
</script>
<script src="{{asset('public/dist/js/maintenance/complaints.js')}}"></script>
@endsection