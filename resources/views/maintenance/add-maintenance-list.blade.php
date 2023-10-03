@extends('layouts.main.app')

@section('title', 'Add Maintenance Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Maintenance</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Maintenance</h1>
<small id="controllerName">Add Maintenance List</small>
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
<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h6 class="fs-17 font-weight-600 mb-0">
                    Add Maintenance Requisition
                    <small class="float-right">
                        <a href="{{route('maintenance-requisitions')}}" class="btn btn-primary btn-md">
                            <i class="ti-arrow-circle-left" aria-hidden="true"></i>
                            Maintenance Requisition List
                        </a>
                    </small>
                </h6>
            </div>
            <div class="card-body">
                <form action="{{route('maintenance-requisitions.add')}}" id="addMaintenRequisitionForm" class="row" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_type" class="col-sm-2 col-form-label">Requisition Type <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="maintenance" name="req_type" class="custom-control-input" value="M">
                                    <label class="custom-control-label" for="maintenance">Breakdown</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="general" name="req_type" class="custom-control-input" value="G">
                                    <label class="custom-control-label" for="general">Periodic</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="requested_by" class="col-sm-5 col-form-label">Requisition By <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="requested_by" id="requested_by">
                                    <option value selected="selected">Select User</option>
                                    @foreach($employeeData['data'] as $employee)
                                    <option value="{{$employee['employeeId'] . '|' . $employee['employeeName']}}">
                                        {{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vehicle_name" id="vehicle_name">
                                    <option value selected="selected">Please Select One</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mainten_type" class="col-sm-5 col-form-label">Maintenance Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="mainten_type" id="mainten_type">
                                    <option value selected="selected">Please Select One</option>
                                    @foreach($maintenanceTypes as $maintenanceType)
                                    <option value="{{$maintenanceType['MAINTENANCE_ID']}}">{{$maintenanceType['MAINTENANCE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mainten_service_name" class="col-sm-5 col-form-label">Maintenance Service Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="mainten_service_name" id="mainten_service_name">
                                    <option value selected="selected">Please Select One</option>
                                    @foreach($maintenanceServices as $maintenanceService)
                                    <option value="{{$maintenanceService['MAINTENANCE_SERVICE_ID']}}">{{$maintenanceService['MAINTENANCE_SERVICE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_date" class="col-sm-5 col-form-label">Service Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="service_date" required class="form-control new-datepicker" type="text" placeholder="Service Date" id="service_date">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="charge" class="col-sm-5 col-form-label">Amount <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="charge" class="form-control" type="text" placeholder="Amount" id="charge">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="charge_bear_by" class="col-sm-5 col-form-label">Charge Bear By </label>
                            <div class="col-sm-7">
                                <input name="charge_bear_by" class="form-control" type="text" placeholder="Charge Bear By" id="charge_bear_by">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="priority" class="col-sm-5 col-form-label">Priority <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="priority" id="priority">
                                    <option value selected="selected">Please Select One</option>
                                    @foreach($priorities as $priority)
                                    <option value="{{$priority['PRIORITY_ID']}}">{{$priority['PRIORITY_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="is_add_schedule" class="col-sm-5 col-form-label"> </label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="is_add_schedule">
                                <label for="checkbox2">Is Add Schedule</label>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="remarks" class="col-sm-5 col-form-label">Remarks</label>
                            <div class="col-sm-7">
                                <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="3" placeholder="Remarks"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="maintenanceInvoiceUpload" class="col-sm-5 col-form-label">Invoice Upload</label>
                            <div class="col-sm-7">
                                <input type="file" name="mainten_invoice" id="maintenanceInvoiceUpload" accept="application/pdf, image/jpeg, image/jpg, image/png">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="card-header p-2">
                            <h6 class="fs-17 font-weight-600 mb-0">Requisition Item Information</h6>
                        </div>
                        <table class="table table-bordered table-hover" id="purchaseTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="20%">Item Type <i class="text-danger">*</i></th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Item Unit <i class="text-danger">*</i>
                                    </th>
                                    <th class="text-center">Warranty</th>
                                    <th class="text-center">Item Amount <i class="text-danger">*</i>
                                    </th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="addPurchaseItem">
                                <tr>
                                    <td class="span3 supplier">
                                        <input type="text" name="product_name[]" required class="form-control product_name" onkeypress="getexpenceitem(1);" placeholder="Item Type Name" id="product_name_1" tabindex="5">
                                    </td>
                                    <td class="wt position-relative"><input type="text" id="itemname_1" class="form-control text-right pitem" name="pitem[]" onkeypress="getpitem(1)">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" required name="product_quantity[]" id="cartoon_1" class="form-control text-right pqty store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value min="0" tabindex="6">
                                    </td>
                                    <td class="text-right">
                                        <input type="text" name="product_warranty[]" id="warranty_1" class="form-control text-right">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" required name="product_rate[]" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate product_rate_1 text-right" placeholder="0.00" value min="0" tabindex="7">
                                    </td>
                                    <td class="test">
                                        <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger red" type="button" value="Delete" onclick="deleteRow(this)" tabindex="8">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <input type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addmore('addPurchaseItem');" value="Add Item" tabindex="9">
                                    </td>
                                    <td class="text-right"><b>Grand Total:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <button type="submit" id="add_purchase" class="btn btn-success w-md m-b-5">Add</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/add_maintenance.js"></script> -->
@if(session('message'))
<script>
    toastr.success('{{session("message")}}', '', {
        closeButton: true
    });
</script>
@endif
<script>
    // Any global variables like routes etc.
</script>
<script src="{{asset('public/dist/js/maintenance/add_mainten_req.js')}}"></script>
@endsection