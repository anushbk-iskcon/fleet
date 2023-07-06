@extends('layouts.main.app')

@section('title', 'Pick-Drop Requisition Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Pick-Drop Requisition Reports</small>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h6>
            </div>
            <div class="card-body">
                <form action="https://vmsdemo.bdtask-demo.com/reports/Reports/pickdropreport" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="routesr" class="col-sm-5 col-form-label justify-content-start text-left">Route </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="routesr" id="routesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="gabtoli to motijeel">gabtoli to motijeel </option>
                                    <option value="Jatrabari to Uttara">Jatrabari to Uttara </option>
                                    <option value="Mohammanpur to khilgao">Mohammanpur to khilgao </option>
                                    <option value="Route1">Route1 </option>
                                    <option value="new">new </option>
                                    <option value="ddd">ddd </option>
                                    <option value="Jatra Bari">Jatra Bari </option>
                                    <option value="qwerty">qwerty </option>
                                    <option value="qwerty">qwerty </option>
                                    <option value="মেঘনা হতে জামগড়া,ফ্যান্টাসি ">মেঘনা হতে জামগড়া,ফ্যান্টাসি </option>
                                    <option value="rgrg">rgrg </option>
                                    <option value="bururi">bururi </option>
                                    <option value="rty">rty </option>
                                    <option value="FGHJKL">FGHJKL </option>
                                    <option value="tguiyo">tguiyo </option>
                                    <option value="Airport To Motijheel">Airport To Motijheel </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="req_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="req_typesr" id="req_typesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Pick Up & Drop Off">
                                        Pick Up & Drop Off</option>
                                    <option value="Drop Off">
                                        Drop Off</option>
                                    <option value="Pick Up">
                                        Pick Up</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="requiest_bysr" class="col-sm-5 col-form-label justify-content-start text-left">Requested By <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="requiest_bysr" id="requiest_bysr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Regular">Regular </option>
                                    <option value="Specific Day">Specific Day </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="req_datesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_datesr" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Requisition Date" id="req_datesr">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="statussr" class="col-sm-5 col-form-label justify-content-start text-left">Status </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="statussr" id="statussr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="pending">Pending</option>
                                    <option value="release">Release</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row  mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 text-right">
                                <button type="button" class="btn btn-success" id="pichdropreq" id="btn-filter">Search</button>
                                <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
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
                <h4 class="pl-3">Pick & Drop Requisition</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pickdropreport" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Route</th>
                                <th>Requisition Date</th>
                                <th>Requisition Type</th>
                                <th>Requested By </th>
                                <th>Requisition For</th>
                                <th>Mobile</th>
                                <th>Department</th>
                                <th>Designation</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Route1</td>
                                <td>2019-08-29</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Regular</td>
                                <td>Jasper Cameron</td>
                                <td>40</td>
                                <td>Computer</td>
                                <td style="display: none;">officer</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>new</td>
                                <td>2019-09-07</td>
                                <td>Drop Off</td>
                                <td>Regular</td>
                                <td>Jasper Cameron</td>
                                <td>40</td>
                                <td>Computer</td>
                                <td style="display: none;">officer</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>gabtoli to motijeel</td>
                                <td>2019-11-17</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Regular</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>ACCOUNTING</td>
                                <td style="display: none;">Supervisor</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Route1</td>
                                <td>2021-02-12</td>
                                <td>Pick Up</td>
                                <td>Specific Day</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>dhaka to chottogram</td>
                                <td>2021-02-23</td>
                                <td>Drop Off</td>
                                <td>Specific Day</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;"></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Route1</td>
                                <td>2021-02-23</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Regular</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>ddd</td>
                                <td>2023-01-25</td>
                                <td>Pick Up</td>
                                <td>Regular</td>
                                <td>Test Employee</td>
                                <td>01785522541</td>
                                <td>ACCOUNTING</td>
                                <td style="display: none;">Supervisor</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Jatra Bari</td>
                                <td>2023-02-02</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Specific Day</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>Jatra Bari</td>
                                <td>2023-02-18</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Specific Day</td>
                                <td>demo2</td>
                                <td>645645546</td>
                                <td>Human Resource</td>
                                <td style="display: none;">Manager</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>qwerty</td>
                                <td>2023-02-18</td>
                                <td>Drop Off</td>
                                <td>Regular</td>
                                <td>abc</td>
                                <td>12345678</td>
                                <td>ACCOUNTING</td>
                                <td style="display: none;">Manager</td>
                            </tr>

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/pickdropreq.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#pickdropreport").DataTable();
    });
</script>

@endsection