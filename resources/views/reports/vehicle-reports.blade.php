@extends('layouts.main.app')

@section('title', 'Vehicle Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Vehicle Reports</small>
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
                        <label for="vehicle" class="col-sm-5 col-form-label justify-content-start text-left">Department </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehicle" id="vehicle">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="????? ?????">????? ?????</option>
                                <option value="mmkmk">mmkmk</option>
                                <option value="iuoioio">iuoioio</option>
                                <option value="Technical">Technical</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="vehicle_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Type <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehicle_typesr" id="vehicle_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="407">407</option>
                                <option value="honda">honda</option>
                                <option value="no ac">no ac</option>
                                <option value="ac">ac</option>
                                <option value="Pick Up">Pick Up</option>
                                <option value="Sedanse">Sedanse</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="ownershipsr" class="col-sm-5 col-form-label justify-content-start text-left">Ownership <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="ownershipsr" id="ownershipsr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="hich">
                                    hich</option>
                                <option value="hich">
                                    hich</option>
                                <option value="hich">
                                    hich</option>
                                <option value="Shrilanka Railways">
                                    Shrilanka Railways</option>
                                <option value="US Railways">
                                    US Railways</option>
                                <option value="Indian Railways">
                                    Indian Railways</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="registration_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Registration Date From </label>
                        <div class="col-sm-7">
                            <input name="registration_date_fr" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Registration Date From" id="registration_date_fr">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="registration_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Registration Date To </label>
                        <div class="col-sm-7">
                            <input name="registration_date_to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Registration Date To" id="registration_date_to">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="vendorsr" class="col-sm-5 col-form-label justify-content-start text-left">Vendor <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vendorsr" id="vendorsr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="asdfas">asdfas </option>
                                <option value="honda">honda </option>
                                <option value="Auto Parts">Auto Parts </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <div class="col-sm-7 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Vehicle Report</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vehicinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th>Registration Date</th>
                                <th>Ownership</th>
                                <th>Vendor</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Test Express 1</td>
                                <td>ac</td>
                                <td>Technical</td>
                                <td>2021-02-17</td>
                                <td>US Railways</td>
                                <td style="display: none;">honda</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Test Express 2</td>
                                <td>Passenger Train</td>
                                <td>Technical</td>
                                <td>2021-02-24</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">Pakistan Railways</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Khyber Express</td>
                                <td>Passenger Train</td>
                                <td>Technical</td>
                                <td>2021-03-02</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">Pakistan Railways</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Test Express 4</td>
                                <td>Passenger Train</td>
                                <td>Technical</td>
                                <td>2021-03-02</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">Pakistan Railways</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>d</td>
                                <td>Pick Up</td>
                                <td>iuoioio</td>
                                <td>2023-01-03</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">Pakistan Railways</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>AS</td>
                                <td>honda</td>
                                <td>Technical</td>
                                <td>2023-03-14</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">honda</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>quad r647</td>
                                <td>ac</td>
                                <td>mmkmk</td>
                                <td>2023-03-16</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">Auto Parts</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Kia Soul</td>
                                <td>Sedanse</td>
                                <td>Technical</td>
                                <td>2023-03-14</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">honda</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>red</td>
                                <td>honda</td>
                                <td>Technical</td>
                                <td>2023-03-01</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">honda</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>Kia</td>
                                <td>honda</td>
                                <td>Technical</td>
                                <td>2023-04-07</td>
                                <td>Pakistan Railways</td>
                                <td style="display: none;">honda</td>
                            </tr>
                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/vehicle_report.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#vehicinfo").DataTable();
    });
</script>
@endsection