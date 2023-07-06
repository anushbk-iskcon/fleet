@extends('layouts.main.app')

@section('title', 'Driver Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Driver Reports</small>
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
                            <label for="mainte_type" class="col-sm-5 col-form-label justify-content-start text-left">Manage Driver </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="driver_list" id="driver_list">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="2">aman - Shah Latif Express</option>
                                    <option value="3">Malik - Khyber Express</option>
                                    <option value="4">Musa Karim - Fareed Express</option>
                                    <option value="8">Khurram</option>
                                    <option value="9">Faris Shafi</option>
                                    <option value="11">driver name</option>
                                    <option value="12">Demo driver 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="vehicle_name" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Name </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle_name" id="vehicle_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Shah Latif Express UP">Shah Latif Express UP </option>
                                    <option value="Sukkur Express UP">Sukkur Express UP </option>
                                    <option value="Khyber Express">Khyber Express </option>
                                    <option value="Fareed Express">Fareed Express </option>
                                    <option value="d">d </option>
                                    <option value="AS">AS </option>
                                    <option value="quad r647">quad r647 </option>
                                    <option value="Kia Soul">Kia Soul </option>
                                    <option value="red">red </option>
                                    <option value="Kia">Kia </option>
                                    <option value="داف">داف </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="mobile" class="col-sm-5 col-form-label justify-content-start text-left">Mobile</label>
                            <div class="col-sm-7">
                                <input name="mobile" class="form-control w-100" type="number" placeholder="Mobile" id="mobile">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Leave Status </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single w-100" name="status" id="status">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="row">
                            <div class="col-sm-12 col-xl-12">
                                <div class="form-group row mb-1">
                                    <label for="date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Join Date From </label>
                                    <div class="col-sm-7">
                                        <input name="date_fr" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Date From" id="date_fr">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-12">
                                <div class="form-group row mb-1">
                                    <label for="date_to" class="col-sm-5 col-form-label justify-content-start text-left">Join Date To </label>
                                    <div class="col-sm-7">
                                        <input name="date_to" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Date To" id="date_to">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label justify-content-start text-left">&nbsp;</label>
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
                <h4 class="pl-3">Driver Report</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dvrport" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Driver Name</th>
                                <th>Assigned vehicle name</th>
                                <th>License Number</th>
                                <th>Mobile</th>
                                <th>Join Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>aman - Shah Latif Express</td>
                                <td></td>
                                <td>29853908634</td>
                                <td>03097894562</td>
                                <td>2019-11-12</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Demo driver 1</td>
                                <td>AS</td>
                                <td>8491678457</td>
                                <td>8546798512</td>
                                <td>0000-00-00</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Demo driver 1</td>
                                <td>Kia Soul</td>
                                <td>8491678457</td>
                                <td>8546798512</td>
                                <td>0000-00-00</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Demo driver 1</td>
                                <td>red</td>
                                <td>8491678457</td>
                                <td>8546798512</td>
                                <td>0000-00-00</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>driver name</td>
                                <td>quad r647</td>
                                <td>1</td>
                                <td>01313368009</td>
                                <td>0000-00-00</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Faris Shafi</td>
                                <td>d</td>
                                <td>001122334455</td>
                                <td>03012234567</td>
                                <td>2021-07-14</td>
                                <td style="display: none;">No</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>Khurram</td>
                                <td>Sukkur Express UP</td>
                                <td>001122334455</td>
                                <td>0301234567</td>
                                <td>2021-02-24</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Malik - Khyber Express</td>
                                <td>Khyber Express</td>
                                <td>23543323423</td>
                                <td>03091234567</td>
                                <td>2020-03-13</td>
                                <td style="display: none;">No</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>Musa Karim - Fareed Express</td>
                                <td>Fareed Express</td>
                                <td>5425325432</td>
                                <td>03011223344</td>
                                <td>2021-01-25</td>
                                <td style="display: none;">Yes</td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/driver_report.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#dvrport").DataTable();
    });
</script>
@endsection