@extends('layouts.main.app')

@section('title', 'Insurance')

@section('css-content')
<style>
    div.error {
        font-size: .8em;
        color: #f66;
    }

    select.error~.select2 .select2-selection {
        border: 1px solid #f99;
    }

    div.file-upload-container {
        display: flex;
        flex-wrap: wrap;
    }

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
<li class="breadcrumb-item active" id="moduleName">Vehicle Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Management</h1>
<small id="controllerName">Insurance Details</small>
@endsection

@section('content')
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Insurance</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('insurance.add')}}" id="addInsuranceDetailsForm" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="company_name" class="col-sm-5 col-form-label">Company Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <!-- <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Company Name"> -->
                                <select name="company_name" id="company_name" class="formn-control basic-single">
                                    <option value="">Please Select</option>
                                    @foreach($insuranceCompanies as $company)
                                    <option value="{{$company['COMPANY_ID']}}">{{$company['COMPANY_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="policy_number" class="col-sm-5 col-form-label">Policy Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="policy_number" required="" class="form-control" type="number" placeholder="Policy Number" id="policy_number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-sm-5 col-form-label">Start Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="start_date" class="form-control new-datepicker" type="text" placeholder="Start Date" id="start_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recurring_period" class="col-sm-5 col-form-label">Recurring Period <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="recurring_period" id="recurring_period">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($recurringPeriods as $recurringPeriod)
                                    @if($recurringPeriod['RECURRING_PERIOD_ID'] == 7) {{-- For default 30 days --}}
                                    <option value="{{$recurringPeriod['RECURRING_PERIOD_ID']}}" selected>{{$recurringPeriod['RECURRING_PERIOD_NAME']}}</option>
                                    @else
                                    <option value="{{$recurringPeriod['RECURRING_PERIOD_ID']}}">{{$recurringPeriod['RECURRING_PERIOD_NAME']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checkbox1" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" name="add_reminder" value="1">
                                <label for="checkbox1">Add Reminder</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checkbox2" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="status" value="1">
                                <label for="checkbox2">Status</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remarks" class="col-sm-5 col-form-label">Remarks </label>
                            <div class="col-sm-7">
                                <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle" id="vehicle">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME'] . ' (' . $vehicle['LICENSE_PLATE'] . ')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="charge_payable" class="col-sm-5 col-form-label">Policy Amount (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="charge_payable" required="" class="form-control" type="number" placeholder="Enter Amount (INR)" id="charge_payable">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-sm-5 col-form-label">End Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="end_date" class="form-control new-datepicker" type="text" placeholder="End Date" id="end_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recurring_date" class="col-sm-5 col-form-label">Recurring Date </label>
                            <div class="col-sm-7">
                                <input name="recurring_date" class="form-control new-datepicker" type="text" placeholder="Recurring Date" id="recurring_date">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="deductible" class="col-sm-5 col-form-label">Deductible <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="deductible" required="" class="form-control" type="number" placeholder="Deductible" id="deductible">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="policy_document" class="col-sm-5 col-form-label">Policy Document </label>
                            <div class="col-sm-7 file-upload-container">
                                <input name="policy_document" type="file" accept="image/jpeg,image/png,application/pdf,.doc,.docx" />
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddInsuranceForm">Reset</button>
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
                <strong>Update Insurance</strong>
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
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Insurance
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form action="" id="insuranceListFilterForm" class="row">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="vehiclesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle <br><br> </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehiclesr" id="vehiclesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME'] . ' (' . $vehicle['LICENSE_PLATE'] . ')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Date From </label>
                            <div class="col-sm-7">
                                <input name="date_fr" autocomplete="off" class="form-control new-datepicker" type="text" placeholder="Date From" id="date_fr">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="insurance_company" class="col-sm-5 col-form-label justify-content-start text-left">Insurance Company</label>
                            <div class="col-sm-7">
                                <!-- <input class="form-control" name="insurance_company" id="insurance_company" type="text" placeholder="Company Name"> -->
                                <select name="insurance_company" id="insurance_company" class="form-control basic-single">
                                    <option value="">Please Select</option>
                                    @foreach($insuranceCompanies as $company)
                                    <option value="{{$company['COMPANY_ID']}}">{{$company['COMPANY_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="date_to" class="col-sm-5 col-form-label justify-content-start text-left">Date To </label>
                            <div class="col-sm-7">
                                <input name="date_to" autocomplete="off" class="form-control new-datepicker" type="text" placeholder="Date To" id="date_to">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="policy_numbersr" class="col-sm-5 col-form-label justify-content-start text- left">Policy Number </label>
                            <div class="col-sm-7">
                                <input name="policy_numbersr" class="form-control" type="text" placeholder="Policy Number" id="policy_numbersr">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row  mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 text-right">
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
                <h4 class="pl-3">Insurance Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="insuranceInfoTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Policy Vendor Name</th>
                                <th>Vehicle Name</th>
                                <th>Policy Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Recurring Period</th>
                                <th>Recurring Date</th>
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/insurance_list.js"></script> -->
<script>
    // To save Routes, URLs, etc. for use in external JS
    let csrfToken = "{{csrf_token()}}";
    let insuranceInfoListURL = "{{route('insurance-list.list')}}";
    let getDetailsURL = "{{route('insurance.details')}}";
    let updateDetailsURL = "{{route('insurance.update')}}";

    let currentYear = moment().year(); // Get current year for use in date pickers

    let recurringPeriods = JSON.parse(`{!! json_encode($recurringPeriods) !!}`);
    // console.log(recurringPeriods);
    let vehicles = JSON.parse(`{!! json_encode($vehicles) !!}`);
    // console.log(vehicles);
    let insuranceCompanies = JSON.parse(`{!! json_encode($insuranceCompanies) !!}`);

    let documentsPath = "{{asset('public/upload/documents/insurance/')}}";
    // console.log(documentsPath);
    // final '/' not included in asset URL output above - to be added when using the URL
</script>
<script src="{{asset('public/dist/js/vehicles/insurance.js')}}">
</script>
@endsection