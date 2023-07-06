@extends('layouts.main.app')

@section('title', 'Refuel Requisition Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Refueling Requisition</small>
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
                        <div class="form-group row mb-1">
                            <label for="fuel_type" class="col-sm-5 col-form-label justify-content-start text-left">Fuel Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="fuel_type" id="fuel_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Diesel">Diesel </option>
                                    <option value="SP95">SP95 </option>
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
                        <div class="form-group row mb-1">
                            <label for="date_to" class="col-sm-5 col-form-label justify-content-start text-left">Date To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="date_to" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Date To" id="date_to">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <div class="col-sm-5">
                                <label for="date_to" class="col-sm-5 col-form-label justify-content-start text-left">Status</label>
                            </div>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="status" id="status">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="release">Release</option>
                                    <option value="pending">Pending</option>
                                </select>
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
                <h4 class="pl-3">Refuel Requisition List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="refureq" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Vehicle Name</th>
                                <th>Fuel Type</th>
                                <th>Odomiter</th>
                                <th>Quantity</th>
                                <th>Fuel Station</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Shah Latif Express UP</td>
                                <td>Diesel</td>
                                <td>2400</td>
                                <td>100</td>
                                <td style="">Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Nissan</td>
                                <td>Diesel</td>
                                <td>2000</td>
                                <td>5</td>
                                <td style="">Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Toyata</td>
                                <td>Octen</td>
                                <td>234</td>
                                <td>10</td>
                                <td style="">Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>MT</td>
                                <td>Petrol</td>
                                <td>500</td>
                                <td>2</td>
                                <td style="">Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>Toyata</td>
                                <td>Octen</td>
                                <td>500</td>
                                <td>2</td>
                                <td style="">Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Navana</td>
                                <td>Diesel</td>
                                <td>50000</td>
                                <td>3</td>
                                <td style="">GM Filling Station</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>16 AJR 367</td>
                                <td>Diesel</td>
                                <td>12</td>
                                <td>3</td>
                                <td>GM Filling Station</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Sukkur Express UP</td>
                                <td>Diesel</td>
                                <td>111</td>
                                <td>111</td>
                                <td>Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>16 AJR 367</td>
                                <td>Diesel</td>
                                <td>12e123</td>
                                <td>100</td>
                                <td>Khalek filling Station</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>648</td>
                                <td>Diesel</td>
                                <td>767676</td>
                                <td>400</td>
                                <td>GM Filling Station</td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/refuelreq.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#refureq").DataTable();
    });
</script>
@endsection