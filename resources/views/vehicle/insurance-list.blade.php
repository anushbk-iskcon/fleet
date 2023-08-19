@extends('layouts.main.app')

@section('title', 'Insurance')

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
                <form action="" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="company_name" class="col-sm-5 col-form-label">Company Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="policy_number" class="col-sm-5 col-form-label">Policy Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="policy_number" required="" class="form-control" type="number" placeholder="Policy Number" id="policy_number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-sm-5 col-form-label">Start Date </label>
                            <div class="col-sm-7">
                                <input name="start_date" class="form-control newdatetimepicker" type="text" placeholder="Start Date" id="start_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recurring_period" class="col-sm-5 col-form-label">Recurring Period <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="recurring_period" id="recurring_period">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="11">11 </option>
                                    <option value="1 Year">1 Year </option>
                                    <option value="1 Month">1 Month </option>
                                    <option value="10 Days">10 Days </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checkbox1" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" name="add_reminder">
                                <label for="checkbox1">Add Reminder</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checkbox2" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="status">
                                <label for="checkbox2">Status</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remarks" class="col-sm-5 col-form-label">Remarks </label>
                            <div class="col-sm-7">
                                <textarea name="remarks" class="form-control" placeholder="Remarks" cols="30" rows="3"></textarea>
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
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="charge_payable" class="col-sm-5 col-form-label">Charge Payable <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="charge_payable" required="" class="form-control" type="number" placeholder="Charge Payable" id="charge_payable">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-sm-5 col-form-label">End Date </label>
                            <div class="col-sm-7">
                                <input name="end_date" class="form-control newdatetimepicker" type="text" placeholder="End Date" id="end_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recurring_date" class="col-sm-5 col-form-label">Recurring Date </label>
                            <div class="col-sm-7">
                                <input name="recurring_date" class="form-control newdatetimepicker" type="text" placeholder="Recurring Date" id="recurring_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deductible" class="col-sm-5 col-form-label">Deductible <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="deductible" required="" class="form-control" type="number" placeholder="Deductible" id="deductible">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="policy_document" class="col-sm-5 col-form-label">Policy Document <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="policy_document" type="file" required="" />
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
                <strong>Update Insurance</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">

            </div>

        </div>
        <div class="modal-footer">

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
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="vehiclesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle <br><br> </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehiclesr" id="vehiclesr">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Date From </label>
                        <div class="col-sm-7">
                            <input name="date_fr" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Date From" id="date_fr">
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="insurance_company" class="col-sm-5 col-form-label justify-content-start text-left">Insurance Company <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="insurance_company" id="insurance_company">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="MetroWaste Solid Waste Management Corp.">MetroWaste Solid Waste Management Corp. </option>
                                <option value="Royal Commission for Jubail & Yanbu">Royal Commission for Jubail & Yanbu </option>
                                <option value="Banglalink">Banglalink </option>
                                <option value="Grameen">Grameen </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="date_to" class="col-sm-5 col-form-label justify-content-start text-left">Date To </label>
                        <div class="col-sm-7">
                            <input name="date_to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Date To" id="date_to">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="policy_numbersr" class="col-sm-5 col-form-label justify-content-start text-left">Policy Number </label>
                        <div class="col-sm-7">
                            <input name="policy_numbersr" class="form-control" type="text" placeholder="Policy Number" id="policy_numbersr">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group row  mb-1">
                        <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
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
                <h4 class="pl-3">Insurance Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Banglalink</td>
                                <td>Kia</td>
                                <td>5464645654</td>
                                <td>2021-02-17</td>
                                <td>2022-03-17</td>
                                <td>1 Year</td>
                                <td>2021-02-17</td>
                                <td><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Grameenphone</td>
                                <td>Fareed Express</td>
                                <td>5464645654</td>
                                <td>2021-03-01</td>
                                <td>2022-02-28</td>
                                <td>1 Year</td>
                                <td>2021-02-28</td>
                                <td><input name="url" type="hidden" id="url_5" value=""><a onclick="editinfo(5)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Banglalink</td>
                                <td>Fareed Express</td>
                                <td>5464645654</td>
                                <td>2021-02-28</td>
                                <td>2021-02-28</td>
                                <td>1 Month</td>
                                <td>2021-02-28</td>
                                <td><input name="url" type="hidden" id="url_6" value=""><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Banglalink</td>
                                <td>Demo</td>
                                <td>5445</td>
                                <td>0000-00-00</td>
                                <td>0000-00-00</td>
                                <td>1 Year</td>
                                <td>0000-00-00</td>
                                <td><input name="url" type="hidden" id="url_8" value=""><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
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
</script>
<script>
    $(document).ready(function() {
        $("#insuranceInfoTable").DataTable();
    });
</script>
@endsection