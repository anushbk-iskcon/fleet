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
                                    <label class="custom-control-label" for="maintenance">Maintenance</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="general" name="req_type" class="custom-control-input" value="G" @if($maintenReqDetails['REQUISITION_TYPE']=='G' ) checked @endif>
                                    <label class="custom-control-label" for="general">General</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="requested_by" class="col-sm-5 col-form-label">Requisition For <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="requested_by" id="requested_by">
                                    <option value selected="selected">Select Employee</option>
                                    <option value="18">
                                        Jasper Cameron_(Computer_EYELDZTR) </option>
                                    <option value="17">
                                        toto_(Technical_EXO9WJ1H) </option>
                                    <option value="6">
                                        Kamrul_(ACCOUNTING_ETMYQ36Y) </option>
                                    <option value="20">
                                        rohit_(Accounting_EQW70GU6) </option>
                                    <option value="15">
                                        sayed_(Human Resource_EQ4QCE9D) </option>
                                    <option value="16">
                                        أمير أبو اسنينة_(????? ?????_EPXJHTX3) </option>
                                    <option value="14">
                                        Rahim_(Technical_EODSVEIF) </option>
                                    <option value="19">
                                        Sandip Sharma_(Marketing & Sales_ELHLYIMC) </option>
                                    <option value="5">
                                        Al Amin_(Human Resource_EKDXW58G) </option>
                                    <option value="8">
                                        abc_(ACCOUNTING_EJ5MOH4S) </option>
                                    <option value="7">
                                        Test Employee_(ACCOUNTING_EDWWDMAV) </option>
                                    <option value="9">
                                        taslimul_(Human Resource_ECN3UOZ8) </option>
                                    <option value="13">
                                        demo2_(Human Resource_E62WYC4J) </option>
                                    <option value="4">
                                        Rashid_(Human Resource_E0CRB403) </option>
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
                                <input name="service_date" required class="form-control newdatetimepicker" type="text" placeholder="Service Date" id="service_date" value="{{$maintenReqDetails['SERVICE_DATE']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_data" class="col-sm-5 col-form-label">Remarks</label>
                            <div class="col-sm-7">
                                <textarea name="remarks" class="form-control" cols="30" rows="3" placeholder="Remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="charge" class="col-sm-5 col-form-label">Charge </label>
                            <div class="col-sm-7">
                                <input name="charge" class="form-control" type="text" placeholder="Charge" id="charge" value="{{$maintenReqDetails['CHARGE']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="charge_bear_by" class="col-sm-5 col-form-label">Charge Bear By </label>
                            <div class="col-sm-7">
                                <input name="charge_bear_by" class="form-control" type="text" placeholder="Charge Bear By" id="charge_bear_by" value="{{$maintenReqDetails['CHARGE_BEAR_BY']}}">
                            </div>
                        </div>
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
                        <div class="form-group row">
                            <label for="is_add_schedule" class="col-sm-5 col-form-label"> </label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="is_add_schedule" @if($maintenReqDetails['IS_SCHEDULED']=='Y' ) checked @endif>
                                <label for="checkbox2">Is Add Schedule</label>
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

</script>
<script src="{{asset('dist/js/maintenance/edit_mainten_req.js')}}"></script>
@endsection