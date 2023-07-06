@extends('layouts.main.app')

@section('title', 'Purchase Details Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Purchase Details</small>
@endsection

@section('content')

<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
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
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-header p-2">
            <h4 class="pl-3">Search Here</h4>
        </div>
        <div class="card-body row">
            <div class="col-sm-12 col-xl-4">
                <div class="form-group row mb-1">
                    <label for="vehicle" class="col-sm-5 col-form-label justify-content-start text-left">Vendor Name </label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single" name="vendor_name" id="vendor_name">
                            <option value="" selected="selected">Please Select One</option>
                            <option value="asdfas">asdfas </option>
                            <option value="honda">honda </option>
                            <option value="Auto Parts">Auto Parts </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="vehicle_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Invoice <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="invoice" id="invoice" type="number" class="form-control" value="" placeholder="Invoice" />
                    </div>
                </div>

            </div>
            <div class="col-sm-12 col-xl-4">
                <div class="form-group row mb-1">
                    <label for="purchase_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Purchase Date From </label>
                    <div class="col-sm-7">
                        <input name="purchase_date_fr" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Purchase Date From" id="purchase_date_fr">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="purchase_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Purchase Date To </label>
                    <div class="col-sm-7">
                        <input name="purchase_date_to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Purchase Date To" id="purchase_date_to">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-4">
                <div class="form-group row mb-1">
                    <div class="col-sm-8 text-right">
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
            <h4 class="pl-3">Purchase Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="purc" class="table display table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice</th>
                            <th>Vendor</th>
                            <th>Purchase Date</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" class="odd">
                            <td class="sorting_1">1</td>
                            <td><input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(1)" style="cursor:pointer;color:#0066CC;">7857654</a></td>
                            <td>Auto Parts</td>
                            <td>2021-02-22</td>
                            <td>1425.00</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">2</td>
                            <td><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(2)" style="cursor:pointer;color:#0066CC;">0032543</a></td>
                            <td>Rahim Afroz</td>
                            <td>2021-02-20</td>
                            <td>530.00</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">3</td>
                            <td><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(7)" style="cursor:pointer;color:#0066CC;">435345n</a></td>
                            <td>honda</td>
                            <td>2021-02-23</td>
                            <td>3340.00</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">4</td>
                            <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(8)" style="cursor:pointer;color:#0066CC;">435345</a></td>
                            <td>Rahim Afroz</td>
                            <td>2021-02-27</td>
                            <td>0.00</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">5</td>
                            <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(10)" style="cursor:pointer;color:#0066CC;">435345n</a></td>
                            <td>Rahim Afroz</td>
                            <td>2021-02-27</td>
                            <td>325.00</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">6</td>
                            <td><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(11)" style="cursor:pointer;color:#0066CC;">gf-432545</a></td>
                            <td>vandor</td>
                            <td>2021-02-27</td>
                            <td>650.00</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">7</td>
                            <td><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(12)" style="cursor:pointer;color:#0066CC;">34</a></td>
                            <td>Honda</td>
                            <td>0000-00-00</td>
                            <td>4.00</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">8</td>
                            <td><input name="url" type="hidden" id="url_13" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(13)" style="cursor:pointer;color:#0066CC;">345566</a></td>
                            <td>Auto Parts</td>
                            <td>2023-02-25</td>
                            <td>2000.00</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">9</td>
                            <td><input name="url" type="hidden" id="url_14" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(14)" style="cursor:pointer;color:#0066CC;">123213</a></td>
                            <td>Auto Parts</td>
                            <td>2023-03-05</td>
                            <td>700.00</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">10</td>
                            <td><input name="url" type="hidden" id="url_15" value="https://vmsdemo.bdtask-demo.com/reports/reports/updatepurchasefrm"><a onclick="editinfo(15)" style="cursor:pointer;color:#0066CC;">12345</a></td>
                            <td>honda</td>
                            <td>2023-03-15</td>
                            <td>12600000.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th class="text-right" colspan="4">Total</th>
                        <th></th>
                    </tfoot>
                </table> <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/purchase_report.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#purc").DataTable();
    });
</script>
@endsection