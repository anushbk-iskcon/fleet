@extends('layouts.main.app')

@section('title', 'Maintenance Req. Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Maintenance Requisition Details</small>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h4>
            </div>
            <div class="card-body">
                <form action="" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="mainte_type" class="col-sm-5 col-form-label justify-content-start text-left">Maintenance Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="mainte_type" id="mainte_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Repair">
                                        Repair</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="vehicle_name" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Name </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle_name" id="vehicle_name">
                                    <option value="" selected="selected">Please Select One</option>
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
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="department" class="col-sm-5 col-form-label justify-content-start text-left">Service From</label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="servicefom" id="servicefom">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Maintenance">
                                        Maintenance</option>
                                    <option value="repair">
                                        repair</option>
                                    <option value="test asdff">
                                        test asdff</option>
                                    <option value="Test">
                                        Test</option>
                                    <option value="mjhkjk">
                                        mjhkjk</option>
                                    <option value="repain ">
                                        repain </option>
                                    <option value="asd">
                                        asd</option>
                                    <option value="BAV">
                                        BAV</option>
                                    <option value="entretien">
                                        entretien</option>
                                    <option value="change bat">
                                        change bat</option>
                                    <option value="645132">
                                        645132</option>
                                    <option value="motor change">
                                        motor change</option>
                                    <option value="Christine Bowman">
                                        Christine Bowman</option>
                                    <option value="Zelenia Morrow">
                                        Zelenia Morrow</option>
                                    <option value="hhh">
                                        hhh</option>
                                    <option value="hh">
                                        hh</option>
                                    <option value="Aceite">
                                        Aceite</option>
                                    <option value="´90YUT">
                                        ´90YUT</option>
                                    <option value="Llantas Cazzu">
                                        Llantas Cazzu</option>
                                    <option value="Oil Change">
                                        Oil Change</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="status" id="status">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="release">Release</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Date From </label>
                            <div class="col-sm-7">
                                <input name="date_fr" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Date From" id="date_fr">
                            </div>
                        </div>
                        <div class="form-group row  mb-1">
                            <label for="date_to" class="col-sm-5 col-form-label justify-content-start text-left">Date To </label>
                            <div class="col-sm-7">
                                <input name="date_to" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Date To" id="date_to">
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
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Maintenance Requisition list</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mainreq" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Requisition Date</th>
                                <th>Maintenance Type</th>
                                <th>Requested By </th>
                                <th>Mobile</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Request Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Fareed Express</td>
                                <td>2019-09-03</td>
                                <td>Repair</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>ACCOUNTING</td>
                                <td>Supervisor</td>
                                <td style="display: none;">2019-09-03</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Khyber Express</td>
                                <td>2019-09-01</td>
                                <td>Repair</td>
                                <td>Test Employee</td>
                                <td>01785522541</td>
                                <td>ACCOUNTING</td>
                                <td>Supervisor</td>
                                <td style="display: none;">2019-09-01</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Toyata</td>
                                <td>2019-11-16</td>
                                <td>Preventive Maintenance</td>
                                <td>Rashid</td>
                                <td>01923001234</td>
                                <td>Human Resource</td>
                                <td>Helper</td>
                                <td style="display: none;">2019-11-16</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>MT</td>
                                <td>2021-01-26</td>
                                <td>Preventive Maintenance</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;">2021-01-26</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>BMW</td>
                                <td>2021-02-25</td>
                                <td>Repair</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;">2021-02-25</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>test from bd</td>
                                <td>2021-02-25</td>
                                <td>Preventive Maintenance</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>ACCOUNTING</td>
                                <td>Supervisor</td>
                                <td style="display: none;">2021-02-25</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>BMW</td>
                                <td>2021-02-25</td>
                                <td>Repair</td>
                                <td>Al Amin</td>
                                <td>01738465735</td>
                                <td>Human Resource</td>
                                <td>Supervisor</td>
                                <td style="display: none;">2021-02-25</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>DEMO3</td>
                                <td>2020-05-05</td>
                                <td>Repair</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;">2020-05-05</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>Hyundai</td>
                                <td>2023-01-18</td>
                                <td>Preventive Maintenance</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>ACCOUNTING</td>
                                <td>Supervisor</td>
                                <td style="display: none;">2023-01-18</td>
                                <td style="display: none;">pending</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>16 AJR 367</td>
                                <td>2023-02-18</td>
                                <td>Repair</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="display: none;">2023-02-18</td>
                                <td style="display: none;">pending</td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="{{asset('dist/js/maintainreport.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#mainreq").DataTable();
    });
</script>
@endsection