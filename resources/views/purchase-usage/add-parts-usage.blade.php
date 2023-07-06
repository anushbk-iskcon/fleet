@extends('layouts.main.app')

@section('title', 'Add Parts Usage')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Purchase</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Purchase</h1>
<small id="controllerName">Add Parts Usage Details</small>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h6 class="fs-17 font-weight-600 mb-0">Add Parts Usage<small class="float-right">
                        <a href="{{route('parts-usages-list')}}" class="btn btn-primary btn-md text-white">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Parts Usages List
                        </a>
                    </small>
                </h6>
            </div>
            <div class="card-body">
                <form action="" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vehicle_name" id="vehicle_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Shah Latif Express UP">Shah Latif Express UP</option>
                                    <option value="Sukkur Express UP">Sukkur Express UP</option>
                                    <option value="Khyber Express">Khyber Express</option>
                                    <option value="Fareed Express">Fareed Express</option>
                                    <option value="d">d</option>
                                    <option value="AS">AS</option>
                                    <option value="quad r647">quad r647</option>
                                    <option value="Kia Soul">Kia Soul</option>
                                    <option value="red">red</option>
                                    <option value="Kia">Kia</option>
                                    <option value="داف">داف</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="invoice" class="col-sm-5 col-form-label">Invoice <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="invoice" required class="form-control" type="text" placeholder="Invoice" value="SL-0011" id="invoice" readonly="readonly">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="usages_date" class="col-sm-5 col-form-label">Usages Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="usages_date" autocomplete="off" required class="form-control newdatetimepicker" type="text" placeholder="Usages Date" id="usages_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="usage_purpose" class="col-sm-5 col-form-label">Purpose </label>
                            <div class="col-sm-7">
                                <input name="usage_purpose" class="form-control" type="text" placeholder="Purpose" id="usage_purpose">
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

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="addPurchaseItem">
                                <tr>
                                    <td class="span3 supplier">
                                        <input type="text" required name="product_name[]" autocomplete="off" required="" class="form-control product_name" onkeypress="getexpenceitem(1);" placeholder="Category Name" id="product_name_1" tabindex="4">
                                    </td>

                                    <td class="wt position-relative">
                                        <input type="text" id="itemname_1" class="form-control text-right pitem" name="pitem[]" autocomplete="off" onkeypress="getpitem(1)" tabindex="5">
                                    </td>

                                    <td class="text-right">
                                        <input type="number" required name="product_quantity[]" id="cartoon_1" class="form-control text-right pqty store_cal_1" placeholder="0.00" value="" min="0" tabindex="6">
                                    </td>

                                    <td>
                                        <button class="btn btn-danger red text-right" type="button" value="Delete" onclick="deleteRow(this)" tabindex="8">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <input type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addmore('addPurchaseItem');" value="Add More item" tabindex="9">
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">
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
<script src="{{asset('dist/js/addusages.js')}}"></script>
@endsection