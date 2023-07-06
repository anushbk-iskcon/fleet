@extends('layouts.main.app')

@section('title', 'Add Expense')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Cost & Inventory</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Cost & Inventory</h1>
<small id="controllerName">Add New Expense</small>
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
                <h4 class="pl-3">Add Expense<small class="float-right">
                        <a href="{{route('manage-expense-types')}}" class="btn btn-primary btn-md">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Manage Expense Type
                        </a>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <form action="" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="expence_cat" class="col-sm-2 col-form-label">Expense category <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="fuel" name="expence_cat" class="custom-control-input" value="Fuel">
                                    <label class="custom-control-label" for="fuel">Fuel</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="maintenance" name="expence_cat" class="custom-control-input" value="Maintenance">
                                    <label class="custom-control-label" for="maintenance">Maintenance</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="other" name="expence_cat" class="custom-control-input" value="Other">
                                    <label class="custom-control-label" for="other">Other</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vehicle_name" id="vehicle_name">
                                    <option value selected="selected">Please Select One</option>
                                    <option value="داف">داف </option>
                                    <option value="Kia">Kia </option>
                                    <option value="red">red </option>
                                    <option value="Kia Soul">Kia Soul </option>
                                    <option value="quad r647">quad r647 </option>
                                    <option value="AS">AS </option>
                                    <option value="d">d </option>
                                    <option value="Fareed Express">Fareed Express </option>
                                    <option value="Khyber Express">Khyber Express </option>
                                    <option value="Sukkur Express UP">Sukkur Express UP </option>
                                    <option value="Shah Latif Express UP">Shah Latif Express UP </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="trip_type" class="col-sm-5 col-form-label">Trip Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="trip_type" id="trip_type">
                                    <option value selected="selected">Please Select One</option>
                                    <option value="Rent Double">
                                        Rent Double</option>
                                    <option value="Rent Single">
                                        Rent Single</option>
                                    <option value="Hire Double">
                                        Hire Double</option>
                                    <option value="Hire Single">
                                        Hire Single</option>
                                    <option value="Own Double">
                                        Own Double</option>
                                    <option value="Own Single">
                                        Own Single</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="odomitter_millage" class="col-sm-5 col-form-label">Odometer/Mileage <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="odomitter_millage" required class="form-control" type="number" placeholder="Odometer/Mileage" id="odomitter_millage">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="invoice" class="col-sm-5 col-form-label">Invoice <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="invoice" required class="form-control" type="text" placeholder="Invoice" id="invoice">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="invoice" class="col-sm-5 col-form-label">Rent Vehicle Cost <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="vehicle_cost" required class="form-control" type="number" placeholder="Rent Vehicle Cost" id="vehicle_cost">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="expense_date" class="col-sm-5 col-form-label">Expense Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="expense_date" required autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expense Date" id="expense_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="trip_number" class="col-sm-5 col-form-label">Trip Number <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="trip_number" required class="form-control" type="number" placeholder="Trip Number" id="trip_number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vendor" class="col-sm-5 col-form-label">Vendor <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vendor" id="vendor">
                                    <option value selected="selected">Please Select One</option>
                                    <option value="asdfas">asdfas </option>
                                    <option value="honda">honda </option>
                                    <option value="Auto Parts">Auto Parts </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="by_whom" class="col-sm-5 col-form-label">By Whom <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="by_whom" id="by_whom">
                                    <option value selected="selected">Please Select One</option>
                                    <option value="Jasper Cameron">
                                        Jasper Cameron_(Computer_40)</option>
                                    <option value="toto">
                                        toto_(Technical_0)</option>
                                    <option value="Kamrul">
                                        Kamrul_(ACCOUNTING_01738465711)</option>
                                    <option value="rohit">
                                        rohit_(Accounting_9897888765)</option>
                                    <option value="sayed">
                                        sayed_(Human Resource_3135441815648)</option>
                                    <option value="أمير أبو اسنينة">
                                        أمير أبو اسنينة_(????? ?????_0598140354)</option>
                                    <option value="Rahim">
                                        Rahim_(Technical_346567678)</option>
                                    <option value="Sandip Sharma">
                                        Sandip Sharma_(Marketing & Sales_9818187054)</option>
                                    <option value="Al Amin">
                                        Al Amin_(Human Resource_01738465735)</option>
                                    <option value="abc">
                                        abc_(ACCOUNTING_12345678)</option>
                                    <option value="Test Employee">
                                        Test Employee_(ACCOUNTING_01785522541)</option>
                                    <option value="taslimul">
                                        taslimul_(Human Resource_12345678)</option>
                                    <option value="demo2">
                                        demo2_(Human Resource_645645546)</option>
                                    <option value="Rashid">
                                        Rashid_(Human Resource_01923001234)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="other_remarks" class="col-sm-5 col-form-label">Other Remarks</label>
                            <div class="col-sm-7">
                                <textarea name="other_remarks" class="form-control" cols="30" rows="3" placeholder="Other Remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <table class="table table-bordered table-hover" id="purchaseTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="20%">Expense Name<i class="text-danger"><i class="text-danger">*</i></i></th>
                                    <th class="text-center">Measurement Unit</th>
                                    <th class="text-center">Unit Price <i class="text-danger">*</i>
                                    </th>
                                    <th class="text-center">Total Amount<i class="text-danger">*</i></th>
                                    <th class="text-center">Action<i class="text-danger">*</i></th>
                                </tr>
                            </thead>
                            <tbody id="addPurchaseItem">
                                <tr class="position-relative">
                                    <td class="span3 supplier">
                                        <input type="text" name="product_name[]" required class="form-control product_name" onkeypress="getexpenceitem(1)" placeholder="Item Name" id="product_name_1" tabindex="5" autocomplete="off">
                                    </td>
                                    <td class="wt">
                                        <input type="number" name="product_quantity[]" id="cartoon_1" class="form-control text-right pqty store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value min="0" tabindex="6">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" name="product_rate[]" required onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate product_rate_1 text-right" placeholder="0.00" value min="0" tabindex="7">
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
                                    <td colspan="2">
                                        <input type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addmore('addPurchaseItem');" value="Add More item" tabindex="9">
                                    </td>
                                    <td class="text-right"><b>Grand Total:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <input type="submit" id="add_purchase" class="btn btn-success btn-large" name="add-purchase" value="Add">
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/expensee_list.js"></script> -->
<script>

</script>

@endsection