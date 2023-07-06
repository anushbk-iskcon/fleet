@extends('layouts.main.app')

@section('title', 'Expense Details Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Expense Details</small>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h4>
            </div>
            <div class="card-body">
                <form action="https://vmsdemo.bdtask-demo.com/#" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="vehicle" class="col-sm-5 col-form-label justify-content-start text-left">Araçlar </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle" id="vehicle">
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
                        <div class="form-group row mb-1">
                            <label for="fuel_type" class="col-sm-5 col-form-label justify-content-start text-left">Expense category </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="expence_cat" id="expence_cat">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Other">Other </option>
                                    <option value="Maintenance">Maintenance </option>
                                    <option value="Fuel">Fuel </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="exp_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Expire Date From </label>
                            <div class="col-sm-7">
                                <input name="exp_date_fr" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Expire Date From" id="exp_date_fr">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="exp_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Expire Date To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="exp_date_to" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Expire Date To" id="exp_date_to">
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
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Expense List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="expenser" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Vehicle Name</th>
                                <th>Category Name</th>
                                <th></th>
                                <th>Trip Number</th>
                                <th>Vendor</th>
                                <th>Odometer/Mileage</th>
                                <th>Invoice</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>DEMO3</td>
                                <td>Other</td>
                                <td>2021-01-06</td>
                                <td>644556</td>
                                <td>Rahim Afroz</td>
                                <td>2</td>
                                <td>3434647</td>
                                <td style="display: none;">1960.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Toyata</td>
                                <td>Maintenance</td>
                                <td>2021-02-17</td>
                                <td>644512</td>
                                <td>Honda</td>
                                <td>1</td>
                                <td>3434613</td>
                                <td style="display: none;">10900.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Navana</td>
                                <td>Fuel</td>
                                <td>2020-06-16</td>
                                <td>64451201</td>
                                <td>Rahim Afroz</td>
                                <td>2</td>
                                <td>78576547</td>
                                <td style="display: none;">10000.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>MT</td>
                                <td>Maintenance</td>
                                <td>2020-07-15</td>
                                <td>54365463</td>
                                <td>Rahim Afroz</td>
                                <td>100</td>
                                <td>Test Invoice</td>
                                <td style="display: none;">4500.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>BMW</td>
                                <td>Maintenance</td>
                                <td>2020-08-12</td>
                                <td>235</td>
                                <td>Honda</td>
                                <td>120</td>
                                <td>6456546</td>
                                <td style="display: none;">5000.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>kuyyi</td>
                                <td>Fuel</td>
                                <td>2020-09-08</td>
                                <td>57567</td>
                                <td>Rahim Afroz</td>
                                <td>35</td>
                                <td>435345</td>
                                <td style="display: none;">3500.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>BMW</td>
                                <td>Maintenance</td>
                                <td>2020-10-08</td>
                                <td>57567</td>
                                <td>vandor</td>
                                <td>35</td>
                                <td>435345n</td>
                                <td style="display: none;">7500.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>BMW</td>
                                <td>Maintenance</td>
                                <td>2020-11-11</td>
                                <td>57567</td>
                                <td>Rahim Afroz</td>
                                <td>35</td>
                                <td>435345n</td>
                                <td style="display: none;">3600.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>DEMO1</td>
                                <td>Maintenance</td>
                                <td>2020-12-16</td>
                                <td>6768678</td>
                                <td>Rahim Afroz</td>
                                <td>150</td>
                                <td>67867878</td>
                                <td style="display: none;">5000.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>DEMO3</td>
                                <td>Maintenance</td>
                                <td>2021-03-14</td>
                                <td>7879789</td>
                                <td>Rahim Afroz</td>
                                <td>150</td>
                                <td>6786789</td>
                                <td style="display: none;">4000.00</td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/expensereport.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#expenser").DataTable();
    });
</script>
@endsection