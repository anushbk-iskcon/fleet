@extends('layouts.main.app')

@section('title', 'Edit Maintenance Requisition')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Maintenance</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Maintenance</h1>
<small id="controllerName">Edit Maintenance List</small>
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
                    Update Maintenance Requisition
                    <small class="float-right">
                        <a href="{{route('maintenance-requisitions')}}" class="btn btn-primary btn-md">
                            <i class="ti-arrow-circle-left" aria-hidden="true"></i>
                            Maintenance Requisition List
                        </a>
                    </small>
                </h6>
            </div>
            <div class="card-body">
                <form action="{{route('maintenance-requisitions.update')}}" id="editMaintenRequisitionForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <input type="hidden" name="mainten_req_id" value="{{$maintenReqDetails['MAINTENANCE_REQ_ID']}}">
                        <div class="form-group row">
                            <label for="req_type" class="col-sm-2 col-form-label">Requisition Type <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="maintenance" name="req_type" class="custom-control-input" value="M" @if($maintenReqDetails['REQUISITION_TYPE']=='M' ) checked @endif>
                                    <label class="custom-control-label" for="maintenance">Breakdown</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="general" name="req_type" class="custom-control-input" value="G" @if($maintenReqDetails['REQUISITION_TYPE']=='G' ) checked @endif>
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
                                    @if($maintenReqDetails['REQUISITION_FOR'] == $employee['employeeId'])
                                    <option value="{{$employee['employeeId'] . '|' . $employee['employeeName']}}" selected>
                                        {{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}
                                    </option>
                                    @else
                                    <option value="{{$employee['employeeId'] . '|' . $employee['employeeName']}}">
                                        {{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}
                                    </option>
                                    @endif
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
                                    @if($maintenReqDetails['VEHICLE_ID'] == $vehicle['VEHICLE_ID'])
                                    <option value="{{$vehicle['VEHICLE_ID']}}" selected>{{$vehicle['VEHICLE_NAME']}}</option>
                                    @else
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endif
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
                                    @if($maintenReqDetails['MAINTENANCE_TYPE'] == $maintenanceType['MAINTENANCE_ID'])
                                    <option value="{{$maintenanceType['MAINTENANCE_ID']}}" selected>{{$maintenanceType['MAINTENANCE_NAME']}}</option>
                                    @else
                                    <option value="{{$maintenanceType['MAINTENANCE_ID']}}">{{$maintenanceType['MAINTENANCE_NAME']}}</option>
                                    @endif
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
                                    @if($maintenReqDetails['MAINTENANCE_SERVICE_NAME'] == $maintenanceService['MAINTENANCE_SERVICE_ID'])
                                    <option value="{{$maintenanceService['MAINTENANCE_SERVICE_ID']}}" selected>{{$maintenanceService['MAINTENANCE_SERVICE_NAME']}}</option>
                                    @else
                                    <option value="{{$maintenanceService['MAINTENANCE_SERVICE_ID']}}">{{$maintenanceService['MAINTENANCE_SERVICE_NAME']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_date" class="col-sm-5 col-form-label">Service Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="service_date" required class="form-control new-datepicker" type="text" placeholder="Service Date" id="service_date" value="{{date('d-M-Y', strtotime($maintenReqDetails['SERVICE_DATE']))}}">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="charge" class="col-sm-5 col-form-label">Amount (INR) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="charge" class="form-control" type="text" placeholder="Amount" id="charge" value="{{$maintenReqDetails['CHARGE']}}">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="charge_bear_by" class="col-sm-5 col-form-label">Charge Bear By </label>
                            <div class="col-sm-7">
                                <input name="charge_bear_by" class="form-control" type="text" placeholder="Charge Bear By" id="charge_bear_by" value="{{$maintenReqDetails['CHARGE_BEAR_BY']}}">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="priority" class="col-sm-5 col-form-label">Priority <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="priority" id="priority">
                                    <option value selected="selected">Please Select One</option>
                                    @foreach($priorities as $priority)
                                    @if($maintenReqDetails['PRIORITY'] == $priority['PRIORITY_ID'])
                                    <option value="{{$priority['PRIORITY_ID']}}" selected>{{$priority['PRIORITY_NAME']}}</option>
                                    @else
                                    <option value="{{$priority['PRIORITY_ID']}}">{{$priority['PRIORITY_NAME']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="is_add_schedule" class="col-sm-5 col-form-label"> </label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="is_add_schedule" @if($maintenReqDetails['IS_SCHEDULED']=='Y' ) checked @endif>
                                <label for="checkbox2">Is Add Schedule</label>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="service_data" class="col-sm-5 col-form-label">Remarks</label>
                            <div class="col-sm-7">
                                <textarea name="remarks" class="form-control" cols="30" rows="3" placeholder="Remarks"></textarea>
                            </div>
                        </div>
                        <div class="from-group row">
                            <label for="" class="col-sm-5 col-form-label">Current Invoice</label>
                            <div class="col-sm-7">
                                @if($maintenReqDetails['INVOICE_FILE'])
                                <a href="{{asset('public/upload/documents/maintenance') . '/' . $maintenReqDetails['INVOICE_FILE']}}" target="_blank" class="btn btn-info">
                                    <i class="fas fa-eye"></i> View Invoice
                                </a>
                                @else
                                <div class="mt-3">No file uploaded</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label for="newInvoiceDocument" class="col-sm-5 col-form-label">Upload New Invoice</label>
                            <div class="col-sm-7">
                                <input type="file" name="mainten_invoice" id="newInvoiceDocument">
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
                                    <th class="text-center" width="20%">Item Type Name<i class="text-danger">*</i></th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Item Unit <i class="text-danger">*</i>
                                    </th>
                                    <th class="text-center">Warranty</th>
                                    <th class="text-center">Unit Price<i class="text-danger">*</i>
                                    </th>

                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="addPurchaseItem">
                                @php $i = 1; @endphp
                                {{-- $i index for each item --}}
                                @foreach($requestedItems as $item)
                                <tr>
                                    <td class="span3 supplier">
                                        <input type="hidden" name="item_id[]" id="itemId{{$i}}" value="{{$item->ITEM_ID}}">
                                        <input type="text" name="product_name[]" required class="form-control product_name" onkeypress="getexpenceitem({{$i}});" placeholder="Item Type Name" id="product_name_{{$i}}" value="{{$item->ITEM_TYPE_NAME}}" tabindex="5">
                                    </td>
                                    <td class="wt position-relative"><input type="text" id="itemname_{{$i}}" class="form-control text-right pitem" name="pitem[]" value="{{$item->ITEM_NAME}}" onkeypress="getpitem({{$i}})">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" required name="product_quantity[]" id="cartoon_{{$i}}" class="form-control text-right pqty store_cal_{{$i}}" onkeyup="calculate_store({{$i}});" onchange="calculate_store({{$i}});" placeholder="0.00" value="{{$item->UNITS}}" min="0" tabindex="6">
                                    </td>
                                    <td>
                                        <input type="text" name="product_warranty[]" id="warranty_{{$i}}" @if($item->WARRANTY_DATE != '1970-01-01' && $item->WARRANTY_DATE != '0000-00-00') value="{{ date('d-M-Y', strtotime($item->WARRANTY_DATE))}}"
                                        @else value="" @endif
                                        class="form-control new-datepicker" placeholder="Warranty Date">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" required name="product_rate[]" value="{{$item->UNIT_PRICE}}" onkeyup="calculate_store({{$i}});" onchange="calculate_store({{$i}});" id="product_rate_{{$i}}" class="form-control product_rate product_rate_{{$i}} text-right" placeholder="0.00" min="0" tabindex="7">
                                    </td>
                                    <td class="test">
                                        <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_{{$i}}" value="{{$item->TOTAL_AMOUNT}}" readonly="readonly">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger red" type="button" value="Delete" onclick="deleteRow(this)" tabindex="8">Delete</button>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <input type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addmore('addPurchaseItem');" value="Add Item" tabindex="9">
                                    </td>
                                    <td class="text-right"><b>Grand Total:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="{{$maintenReqDetails['TOTAL_AMOUNT']}}" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <button type="submit" id="update_purchase" class="btn btn-success w-md m-b-5">Save</button>
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/maintenance_edit.js"></script> -->
<script>
    let csrfToken = '{{csrf_token()}}';
    let uploadDocumentsPath = "{{asset('public/upload/documents/maintenance/')}}";
</script>
<script src="{{asset('public/dist/js/maintenance/edit_mainten_req.js')}}"></script>
@endsection