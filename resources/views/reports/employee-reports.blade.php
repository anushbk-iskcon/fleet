@extends('layouts.main.app')

@section('title', 'Employee Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Employee Reports</small>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h4>
            </div>
            <form action="https://vmsdemo.bdtask-demo.com/reports/reports/index" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                <div class="card-body row">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="emp_type" class="col-sm-5 col-form-label justify-content-start text-left">Employee Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="emp_types" id="emp_types">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="External">External </option>
                                    <option value="Internal">Internal </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="blood" class="col-sm-5 col-form-label justify-content-start text-left">Blood Group </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="shbloodg" id="shbloodg">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value=""> </option>
                                    <option value="A+">A+ </option>
                                    <option value="A-">A- </option>
                                    <option value="AB+">AB+ </option>
                                    <option value="O+">O+ </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="department" class="col-sm-5 col-form-label justify-content-start text-left">Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="departmentsh" id="departmentsh">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Accounting">
                                        Accounting</option>
                                    <option value="Human Resource">
                                        Human Resource</option>
                                    <option value="Marketing & Sales">
                                        Marketing & Sales</option>
                                    <option value="Technical">
                                        Technical</option>
                                    <option value="mmkmk">
                                        mmkmk</option>
                                    <option value="Planning department">
                                        Planning department</option>
                                    <option value="Testing">
                                        Testing</option>
                                    <option value="Computer">
                                        Computer</option>
                                    <option value="Rose Water">
                                        Rose Water</option>
                                    <option value="yhyh">
                                        yhyh</option>
                                    <option value="Administration">
                                        Administration</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="designation" class="col-sm-5 col-form-label justify-content-start text-left">Designation <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="designationsh" id="designationsh">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Supervisor">Supervisor </option>
                                    <option value="Manager">Manager </option>
                                    <option value="Accounts">Accounts </option>
                                    <option value="Helper">Helper </option>
                                    <option value="Receptionist">Receptionist </option>
                                    <option value="Palero">Palero </option>
                                    <option value="testing">testing </option>
                                    <option value="officer">officer </option>
                                    <option value="Customer">Customer </option>
                                    <option value="????">???? </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="row">
                            <div class="col-sm-12 col-xl-12">
                                <div class="form-group row mb-1">
                                    <label for="join_datefrsh" class="col-sm-5 col-form-label justify-content-start text-left">Joining Date From </label>
                                    <div class="col-sm-7">
                                        <input name="join_datefrsh" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Joining Date From" id="join_datefrsh">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-12">
                                <div class="form-group row  mb-1">
                                    <label for="joining_d_to" class="col-sm-5 col-form-label justify-content-start text-left">Joining Date To </label>
                                    <div class="col-sm-7">
                                        <input name="joining_d_to" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Joining Date To" id="joining_d_to">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 text-right">
                                <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
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
            <h4 class="pl-3">Manage Employee</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="empreport" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>NID</th>
                            <th>Type</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Mobile</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" class="odd">
                            <td class="sorting_1" tabindex="0">1</td>
                            <td>Rashid</td>
                            <td>5551177244338801</td>
                            <td>External</td>
                            <td>Human Resource</td>
                            <td>Helper</td>
                            <td>01923001234</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1" tabindex="0">2</td>
                            <td>Al Amin</td>
                            <td>0214253645674577</td>
                            <td>External</td>
                            <td>Human Resource</td>
                            <td>Supervisor</td>
                            <td>01738465735</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1" tabindex="0">3</td>
                            <td>Kamrul</td>
                            <td>987214253667854</td>
                            <td>External</td>
                            <td>ACCOUNTING</td>
                            <td>Supervisor</td>
                            <td>01738465711</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1" tabindex="0">4</td>
                            <td>Test Employee</td>
                            <td>53453434</td>
                            <td>External</td>
                            <td>ACCOUNTING</td>
                            <td>Supervisor</td>
                            <td>01785522541</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1" tabindex="0">5</td>
                            <td>abc</td>
                            <td>657657567</td>
                            <td>External</td>
                            <td>ACCOUNTING</td>
                            <td>Manager</td>
                            <td>12345678</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1" tabindex="0">6</td>
                            <td>Rahim</td>
                            <td>4567</td>
                            <td>External</td>
                            <td>Technical</td>
                            <td>Manager</td>
                            <td>346567678</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1" tabindex="0">7</td>
                            <td>sayed</td>
                            <td>852963159</td>
                            <td>External</td>
                            <td>Human Resource</td>
                            <td>Supervisor</td>
                            <td>3135441815648</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1" tabindex="0">8</td>
                            <td>أمير أبو اسنينة</td>
                            <td>12345689655</td>
                            <td>External</td>
                            <td>????? ?????</td>
                            <td>Driver</td>
                            <td>0598140354</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1" tabindex="0">9</td>
                            <td>Jasper Cameron</td>
                            <td>88</td>
                            <td>External</td>
                            <td>Computer</td>
                            <td>officer</td>
                            <td>40</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1" tabindex="0">10</td>
                            <td>Sandip Sharma</td>
                            <td>0981981</td>
                            <td>External</td>
                            <td>Marketing &amp; Sales</td>
                            <td>Manager</td>
                            <td>9818187054</td>
                        </tr>
                    </tbody>
                </table> <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
</div>
<!-- <script src="{{asset('dist/js/reports_employee_view.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#empreport").DataTable();
    });
</script>
@endsection