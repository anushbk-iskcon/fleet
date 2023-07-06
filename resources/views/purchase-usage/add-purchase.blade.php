@extends('layouts.main.app')

@section('title', 'Add Purchase')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Purchase</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Purchase</h1>
<small id="controllerName">Add Purchase Details</small>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h6 class="fs-17 font-weight-600 mb-0">Add Purchase<small class="float-right">
                        <a href="{{url('purchases')}}" class="btn btn-primary btn-md text-white"><i class="ti-plus" aria-hidden="true"></i>
                            Purchase Details</a>
                    </small>
                </h6>
            </div>
            <div class="card-body">
                <form action="" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vendor Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vendor_name" id="vendor_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Auto Parts">Auto Parts </option>
                                    <option value="honda">honda </option>
                                    <option value="asdfas">asdfas </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="invoice" class="col-sm-5 col-form-label">Invoice <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="invoice" required class="form-control" type="text" placeholder="Invoice" id="invoice">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="workorder" class="col-sm-5 col-form-label">Work Order Image <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="file" accept="image/*" name="workorder" required>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="purchase_dade" class="col-sm-5 col-form-label">Purchase Date </label>
                            <div class="col-sm-7">
                                <input name="purchase_dade" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Purchase Date" id="purchase_dade">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="manual_req" class="col-sm-5 col-form-label">Manual Requisition Image <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="file" required accept="image/*" name="manual_req">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-12">
                        <table class="table table-bordered table-hover" id="purchaseTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="20%">Category Name<i class="text-danger">*</i></th>
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
                                <tr>
                                    <td class="span3 supplier">
                                        <input type="text" name="product_name[]" autocomplete="off" required="" class="form-control product_name" onkeypress="getexpenceitem(1);" placeholder="Category Name" id="product_name_1" tabindex="5">
                                    </td>

                                    <td class="wt position-relative"><input type="text" autocomplete="off" id="itemname_1" class="form-control text-right pitem" name="pitem[]" onkeypress="getpitem(1)">
                                    </td>

                                    <td class="text-right">
                                        <input type="number" required name="product_quantity[]" id="cartoon_1" class="form-control text-right pqty store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="" min="0" tabindex="6">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" required name="product_rate[]" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="7">
                                    </td>
                                    <td class="test">
                                        <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger red text-right" type="button" value="Delete" onclick="deleteRow(this)" tabindex="8">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <input type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addmore('addPurchaseItem');" value="Add More item" tabindex="9">
                                    </td>
                                    <td class="text-right"><b>Grand Total:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/addpurchase.js"></script> -->
@endsection