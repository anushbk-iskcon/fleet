@extends('layouts.main.app')

@section('title', 'Vehicle Requisition Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Vehicle Requisition Reports</small>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="req_forsr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition For </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="req_forsr" id="req_forsr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Jasper Cameron">
                                    Jasper Cameron_(Computer_EYELDZTR) </option>
                                <option value="toto">
                                    toto_(Technical_EXO9WJ1H) </option>
                                <option value="Kamrul">
                                    Kamrul_(ACCOUNTING_ETMYQ36Y) </option>
                                <option value="rohit">
                                    rohit_(Accounting_EQW70GU6) </option>
                                <option value="sayed">
                                    sayed_(Human Resource_EQ4QCE9D) </option>
                                <option value="Rahim">
                                    Rahim_(Technical_EODSVEIF) </option>
                                <option value="Sandip Sharma">
                                    Sandip Sharma_(Marketing & Sales_ELHLYIMC) </option>
                                <option value="Al Amin">
                                    Al Amin_(Human Resource_EKDXW58G) </option>
                                <option value="abc">
                                    abc_(ACCOUNTING_EJ5MOH4S) </option>
                                <option value="Test Employee">
                                    Test Employee_(ACCOUNTING_EDWWDMAV) </option>
                                <option value="taslimul">
                                    taslimul_(Human Resource_ECN3UOZ8) </option>
                                <option value="demo2">
                                    demo2_(Human Resource_E62WYC4J) </option>
                                <option value="Rashid">
                                    Rashid_(Human Resource_E0CRB403) </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="vehicle_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Type </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehicle_typesr" id="vehicle_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Sedanse">
                                    Sedanse</option>
                                <option value="Pick Up">
                                    Pick Up</option>
                                <option value="ac">
                                    ac</option>
                                <option value="no ac">
                                    no ac</option>
                                <option value="honda">
                                    honda</option>
                                <option value="407">
                                    407</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="drivenby" class="col-sm-5 col-form-label justify-content-start text-left">Driven By </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="drivenby" id="drivenby">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="2">
                                    aman - Shah Latif Express_(03097894562)</option>
                                <option value="3">
                                    Malik - Khyber Express_(03091234567)</option>
                                <option value="4">
                                    Musa Karim - Fareed Express_(03011223344)</option>
                                <option value="8">
                                    Khurram_(0301234567)</option>
                                <option value="9">
                                    Faris Shafi_(03012234567)</option>
                                <option value="11">
                                    driver name_(01313368009)</option>
                                <option value="12">
                                    Demo driver 1_(8546798512)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="1">Approved</option>
                                <option value="0">Denied </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="from" class="col-sm-5 col-form-label justify-content-start text-left">From </label>
                        <div class="col-sm-7">
                            <input name="from" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="From" id="from">
                        </div>

                    </div>
                    <div class="form-group row mb-1">
                        <label for="to" class="col-sm-5 col-form-label justify-content-start text-left">To </label>
                        <div class="col-sm-7">
                            <input name="to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="To" id="to">
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
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Requisition List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reqlist" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requisition For</th>
                                <th>User Mobile</th>
                                <th>Requisition Date</th>
                                <th>Driver Name</th>
                                <th>Driver Mobile</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Duration</th>
                                <th>Total Passenger</th>
                                <th>Purpose</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2023-02-15</td>
                                <td>aman - Shah Latif Express</td>
                                <td>03097894562</td>
                                <td>dsds</td>
                                <td>dsds</td>
                                <td style="display: none;">dsd</td>
                                <td style="display: none;">4</td>
                                <td style="display: none;">site seeing</td>
                                <td style="display: none;">dsdsds</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td></td>
                                <td></td>
                                <td>2021-02-11</td>
                                <td>Malik - Khyber Express</td>
                                <td>03091234567</td>
                                <td>dhaka</td>
                                <td>ctg</td>
                                <td style="display: none;">1 hour</td>
                                <td style="display: none;">8</td>
                                <td style="display: none;">Travelee</td>
                                <td style="display: none;">k.jl.j.kl.lk.lk.lkj.</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2021-02-25</td>
                                <td>Malik - Khyber Express</td>
                                <td>03091234567</td>
                                <td>drfsd</td>
                                <td>srtrs</td>
                                <td style="display: none;">1</td>
                                <td style="display: none;">0</td>
                                <td style="display: none;">Picnic</td>
                                <td style="display: none;">srtt</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2021-03-02</td>
                                <td>Musa Karim - Fareed Express</td>
                                <td>03011223344</td>
                                <td>fghgf</td>
                                <td>hfg</td>
                                <td style="display: none;">56</td>
                                <td style="display: none;">0</td>
                                <td style="display: none;">official</td>
                                <td style="display: none;">rtyrtyt</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2023-03-07</td>
                                <td>Khurram</td>
                                <td>0301234567</td>
                                <td>Kuruwita</td>
                                <td>Avissawella</td>
                                <td style="display: none;">1</td>
                                <td style="display: none;">2</td>
                                <td style="display: none;">official</td>
                                <td style="display: none;">s</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2023-03-16</td>
                                <td>Faris Shafi</td>
                                <td>03012234567</td>
                                <td>reduto</td>
                                <td>manhuaçu</td>
                                <td style="display: none;">1</td>
                                <td style="display: none;">5</td>
                                <td style="display: none;">official</td>
                                <td style="display: none;">rota</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2023-03-17</td>
                                <td>Faris Shafi</td>
                                <td>03012234567</td>
                                <td>abu dhabi</td>
                                <td>abu dhabi</td>
                                <td style="display: none;">20</td>
                                <td style="display: none;">2</td>
                                <td style="display: none;">official</td>
                                <td style="display: none;">transfer</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Kamrul</td>
                                <td>01738465711</td>
                                <td>2023-03-24</td>
                                <td>Faris Shafi</td>
                                <td>03012234567</td>
                                <td>scvb</td>
                                <td>bsvbd</td>
                                <td style="display: none;">5</td>
                                <td style="display: none;">20</td>
                                <td style="display: none;">official</td>
                                <td style="display: none;">bsdfbfsd</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>Jasper Cameron</td>
                                <td>40</td>
                                <td>2023-04-07</td>
                                <td>Faris Shafi</td>
                                <td>03012234567</td>
                                <td>Kumasi</td>
                                <td>Accra</td>
                                <td style="display: none;">6 hours</td>
                                <td style="display: none;">2</td>
                                <td style="display: none;">site seeing</td>
                                <td style="display: none;">Offload </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>Jasper Cameron</td>
                                <td>40</td>
                                <td>0000-00-00</td>
                                <td>driver name</td>
                                <td>01313368009</td>
                                <td>knock</td>
                                <td>Serbia</td>
                                <td style="display: none;">ere</td>
                                <td style="display: none;">0</td>
                                <td style="display: none;">site seeing</td>
                                <td style="display: none;">asdf</td>
                            </tr>
                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/requisition_report.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#reqlist").DataTable();
    });
</script>
@endsection